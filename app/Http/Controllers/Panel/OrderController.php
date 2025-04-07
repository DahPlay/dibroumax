<?php

namespace App\Http\Controllers\Panel;

use App\Enums\CycleAsaasEnum;
use App\Enums\PaymentStatusOrderAsaasEnum;
use App\Enums\StatusOrderAsaasEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Package;
use App\Models\Plan;
use App\Services\AppIntegration\PlanCancelService;
use App\Services\AppIntegration\PlanCreateService;
use App\Services\PaymentGateway\Connectors\AsaasConnector;
use App\Services\PaymentGateway\Gateway;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    protected $model;
    protected $request;

    public function __construct(Order $order, Request $request)
    {
        $this->model = $order;
        $this->request = $request;
    }

    public function index(): View
    {
        return view($this->request->route()->getName());
    }

    public function loadDatatable(): JsonResponse
    {
        $orders = $this->model
            ->with(['customer:id,name', 'plan:id,name'])
            ->select([
                'orders.id',
                'orders.customer_id',
                'orders.plan_id',
                'orders.value',
                'orders.subscription_asaas_id',
                'orders.customer_asaas_id',
                'orders.cycle',
                'orders.status',
                'orders.next_due_date',
                'orders.payment_status',
                'orders.created_at',
            ]);

        return DataTables::of($orders)
            ->addColumn('checkbox', function ($order) {
                return view('panel.orders.local.index.datatable.checkbox', compact('order'));
            })
            ->editColumn('id', function ($order) {
                return view('panel.orders.local.index.datatable.id', compact('order'));
            })
            ->filterColumn('status', function ($query, $keyword) {
                $matchingCycles = collect(StatusOrderAsaasEnum::cases())
                    ->filter(fn($enum) => str_contains($enum->getName(), $keyword))
                    ->pluck('value')
                    ->toArray();

                $query->whereIn('status', $matchingCycles);
            })
            ->editColumn('payment_status', function ($order) {
                $currentDate = Carbon::now()->startOfDay();
                $nextDueDate = Carbon::parse($order->next_due_date)->startOfDay();

                if ($nextDueDate->gte($currentDate)) {
                    return 'GRÁTIS';
                }
                return 'PAGO';
            })
            ->filterColumn('payment_status', function ($query, $keyword) {
                $matchingCycles = collect(PaymentStatusOrderAsaasEnum::cases())
                    ->filter(fn($enum) => str_contains($enum->getName(), $keyword))
                    ->pluck('value')
                    ->toArray();

                $query->whereIn('payment_status', $matchingCycles);
            })
            ->filterColumn('cycle', function ($query, $keyword) {
                $matchingCycles = collect(CycleAsaasEnum::cases())
                    ->filter(fn($enum) => str_contains($enum->getName(), $keyword))
                    ->pluck('value')
                    ->toArray();

                $query->whereIn('cycle', $matchingCycles);
            })
            ->editColumn('next_due_date', function ($order) {
                return $order->next_due_date ? date('d/m/Y', strtotime($order->next_due_date)) : 'Sem data';
            })
            ->filterColumn('next_due_date', function ($query, $value) {
                $query->whereRaw("DATE_FORMAT(next_due_date,'%d/%m/%Y') like ?", ["%$value%"]);
            })
            ->editColumn('created_at', function ($order) {
                return $order->created_at ? date('d/m/Y H:i:s', strtotime($order->created_at)) : 'Sem data';
            })
            ->filterColumn('created_at', function ($query, $value) {
                $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y %H:%i:%s') like ?", ["%$value%"]);
            })
            ->addColumn('action', function ($order) {
                $loggedId = auth()->user()->id;

                return view('panel.orders.local.index.datatable.action', compact('order', 'loggedId'));
            })
            ->toJson();
    }

    public function create(): View
    {
        $order = $this->model;

        return view('panel.orders.local.index.modals.create', compact('order'));
    }

    public function store(): JsonResponse
    {
        $data = $this->request->only([
            'name',
        ]);

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        }

        if ($this->request->hasFile('photo')) {
            $data["photo"] = $this->request->file('photo')->store('avatars');
        }

        $order = $this->model->create($data);

        if ($order) {
            return response()->json([
                'status' => '200',
                'message' => 'Ação executada com sucesso!'
            ]);
        } else {
            return response()->json([
                'status' => '400',
                'errors' => [
                    'message' => ['Erro executar a ação, tente novamente!']
                ]
            ]);
        }
    }

    public function edit($id): View
    {
        $order = $this->model->find($id);

        return view('panel.orders.local.index.modals.edit', compact("order"));
    }

    public function update($id): JsonResponse
    {
        $order = $this->model->find($id);

        if ($order) {
            $data = $this->request->only([
                'name',
            ]);

            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:100'],
            ]);

            if (count($validator->errors()) > 0) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->errors(),
                ]);
            }

            $order->update($data);

            if ($order) {
                return response()->json([
                    'status' => '200',
                    'message' => 'Ação executada com sucesso!'
                ]);
            } else {
                return response()->json([
                    'status' => '400',
                    'errors' => [
                        'message' => ['Erro executar a ação, tente novamente!']
                    ]
                ]);
            }
        } else {
            return response()->json([
                'status' => '400',
                'errors' => [
                    'message' => ['Os dados não foram encontrados!']
                ]
            ]);
        }
    }

    public function delete($id): View
    {
        $order = $this->model->find($this->request->id);

        return view('panel.orders.local.index.modals.delete', compact("order"));
    }

    public function destroy(): JsonResponse
    {
        $order = $this->model->find($this->request->id);

        if ($order) {
            $delete = $order->delete();

            if ($delete) {
                return response()->json([
                    'status' => '200',
                    'message' => 'Ação executada com sucesso!'
                ]);
            } else {
                return response()->json([
                    'status' => '400',
                    'errors' => [
                        'message' => ['Erro executar a ação, tente novamente!']
                    ],
                ]);
            }
        } else {
            return response()->json([
                'status' => '400',
                'errors' => [
                    'message' => ['Os dados não foram encontrados!']
                ],
            ]);
        }
    }

    public function deleteAll(): View
    {
        $itens = $this->request->checkeds;

        session()->put('ids', $itens);

        return view('panel.orders.local.index.modals.remove-all', compact("itens"));
    }

    public function destroyAll(): JsonResponse
    {
        foreach (session()->get('ids') as $item) {
            $item = $this->model->find($item["id"]);

            if ($item) {
                $item->delete();

                if (!$item) {
                    return response()->json([
                        'status' => '400',
                        'errors' => [
                            'message' => ['Erro executar a ação, tente novamente!']
                        ],
                    ]);
                }
            } else {
                return response()->json([
                    'status' => '400',
                    'errors' => [
                        'message' => ['Os dados não foram encontrados!']
                    ],
                ]);
            }
        }

        return response()->json([
            'status' => '200',
            'message' => 'Ação executada com sucesso!'
        ]);
    }

    public function show($id): View
    {
        $order = $this->model->find($id);

        return view('panel.orders.local.index.modals.show', compact("order"));
    }

    public function duplicate(): View
    {
        $order = $this->model->find($this->request->id);

        return view('panel.orders.local.index.modals.duplicate', compact('order'));
    }

    public function cancel($id): View
    {
        $order = $this->model->find($this->request->id);

        return view('panel.orders.local.index.modals.cancel', compact("order"));
    }

    public function changePlan($id): View
    {
        $order = $this->model->find($this->request->id);
        $data = Plan::getPlansData();

        return view('panel.orders.local.index.modals.change-plan', [
            'actualPlan' => $order->plan_id,
            'order' => $order,
            'cycles' => $data['cycles'],
            'plansByCycle' => $data['plansByCycle'],
            'activeCycle' => $data['activeCycle']
        ]);
    }

    public function changePlanStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'planId' => 'required',
            'orderId' => 'required',
        ]);

        $planId = $validator->validated()['planId'];

        if (auth()->user()->hasPlan($planId)) {
            toastr('Este é o seu plano atual, escolha outro plano.', 'warning');
            return redirect()->back();
        }

        $plan = Plan::find($planId);
        $order = $this->model->find($validator->validated()['orderId']);

        $oldPlan = Plan::where('id', $order->plan_id)->first();

        if ($order->next_due_date < now()
            && $order->payment_status !== PaymentStatusOrderAsaasEnum::RECEIVED->getName()) {
            toastr(
                'Se já fez o pagamento, por favor, aguarde a efetivação pelo sistema.',
                'info',
                'Seu plano está vencido. Realize o pagamento antes de continuar!',
            );
            return redirect()->back();
        }
        $adapter = app(AsaasConnector::class);
        $gateway = new Gateway($adapter);

        if ($order) {
            $actualPlanValue = $order->value;
            $billingCycle = $order->cycle;
            $invoiceValue = $plan->value;

            $cycleDays = match ($billingCycle) {
                'WEEKLY' => 7,
                'BIWEEKLY' => 14,
                'MONTHLY' => 30,
                'BIMONTHLY' => 60,
                'QUARTERLY' => 90,
                'SEMIANNUALLY' => 180,
                'YEARLY' => 365,
                default => 30,
            };

            $payment = $gateway->payment()->get($order->payment_asaas_id);

            // Se tem cobrança pendente e ainda não está vencida
            if ($payment['status'] === 'PENDING' && $payment['dueDate'] >= Carbon::now()->format('Y-m-d')) {
                // Descobre quantos dias já foram usados no ciclo atual
                $daysUsed = $cycleDays - now()->diffInDays($order->next_due_date);
                if ($daysUsed > 0 && $daysUsed < $cycleDays) {
                    // Calcula o valor proporcional restante do plano atual
                    $dailyRate = $actualPlanValue / $cycleDays;
                    $credit = $dailyRate * ($cycleDays - $daysUsed);

                    // Calcula o valor final do novo plano considerando o crédito
                    $invoiceValue = max(0, $plan->value - $credit);
                }

                //remove a cobrança no asaas
                $paymentDeleted = $gateway->payment()->delete($order->payment_asaas_id);

                if ($paymentDeleted['deleted']) {
                    logger("Pagamento removido no Asaas para atualização de plano. Pedido: $order->id");
                } else {
                    logger("Erro ao remover pagamento no Asaas para atualização de plano. Pedido: $order->id");
                }
            }

            //caso seja downgrade eu só atualizo a fatura do próximo mês
            if ($order->plan->value < $plan->value) {
                $this->updateSubscription($order, $plan->value, $plan, $gateway, $oldPlan);
            }

            // Atualiza a assinatura no Asaas com o novo valor ajustado e na Youcast com os novos pacotes
            $this->updateSubscription($order, $invoiceValue, $plan, $gateway, $oldPlan);

            return redirect()->route('panel.orders.index');
        }
    }

    protected function updateSubscription($order, $invoiceValue, $plan, $gateway, $oldPlan)
    {
        $data = [
            'id' => $order->subscription_asaas_id,
            'billingType' => $plan->billing_type,
            'value' => $invoiceValue,
            'nextDueDate' => now()->format('Y-m-d'),
            'description' => "Troca de plano para o plano: $plan->name",
            'externalReference' => 'Pedido: ' . $order->id,
        ];

        $response = $gateway->subscription()->update($order->subscription_asaas_id, $data);

        if ($response['object'] === 'subscription') {
            $packagesToCancel = [];
            foreach ($oldPlan->packagePlans as $packagePlan) {
                $pack = Package::find($packagePlan->package_id);
                $packagesToCancel[] = $pack->cod;
            };

            //cancelo na youcast os pacotes antigos
            (new PlanCancelService($packagesToCancel, $order->customer->viewers_id))->cancelPlan();

            //cadastro na youcast os pacotes novos
            $packagesToCreate = [];
            foreach ($plan->packagePlans as $packagePlan) {
                $pack = Package::find($packagePlan->package_id);
                $packagesToCreate[] = $pack->cod;
            };

            (new PlanCreateService($packagesToCreate, $order->customer->viewers_id))->createPlan();

            //Salvo na order os dados do plano antigo para voltar o cliente se ele não pagar
            $order->update([
                'plan_id' => $plan->id,
                'description' => $plan->description,
                'changed_plan' => true,
                'original_plan_value' => $plan->value
            ]);

            toastr('Assinatura atualizada com sucesso!', 'success');
            return;
        }

        toastr('Erro ao atualizar assinatura!', 'error');
    }

    public function canceling(): JsonResponse
    {
        $order = $this->model->find($this->request->id);

        if ($order) {
            $adapter = app(AsaasConnector::class);

            $gateway = new Gateway($adapter);

            $response = $gateway->subscription()->delete($order->subscription_asaas_id);

            if (!$response['deleted']) {
                Log::error(
                    "Erro ao cancelar assinatura - linha 306 - OrderController {$order->customer->name} - {$order->id}"
                );

                return response()->json([
                    'status' => '400',
                    'errors' => [
                        'message' => ['Erro executar a ação, tente novamente!']
                    ],
                ]);
            }

            $order->deleted_date = now();
            $order->status = 'INACTIVE';
            $order->save();

            if ($response['id']) {
                return response()->json([
                    'status' => '200',
                    'message' => 'Ação executada com sucesso!'
                ]);
            } else {
                return response()->json([
                    'status' => '400',
                    'errors' => [
                        'message' => ['Erro executar a ação, tente novamente!']
                    ],
                ]);
            }
        } else {
            return response()->json([
                'status' => '400',
                'errors' => [
                    'message' => ['Os dados não foram encontrados!']
                ],
            ]);
        }
    }
}
