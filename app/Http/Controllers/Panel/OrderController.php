<?php

namespace App\Http\Controllers\Panel;

use App\Enums\CycleAsaasEnum;
use App\Enums\PaymentStatusOrderAsaasEnum;
use App\Enums\StatusOrderAsaasEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\PaymentGateway\Connectors\AsaasConnector;
use App\Services\PaymentGateway\Gateway;
use App\Services\YouCast\Plan\PlanCancel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\View\View;

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

    public function canceling(): JsonResponse
    {
        $order = $this->model->find($this->request->id);

        if ($order) {

            $adapter = app(AsaasConnector::class);

            $gateway = new Gateway($adapter);

            $response = $gateway->subscription()->delete($order->subscription_asaas_id);

            if (!$response['deleted']) {
                Log::error("Erro ao cancelar assinatura - linha 306 - OrderController {$order->customer->name} - {$order->id}");

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
