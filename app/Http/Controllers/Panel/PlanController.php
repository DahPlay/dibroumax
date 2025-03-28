<?php

namespace App\Http\Controllers\Panel;

use App\Enums\BillingTypeAsaasEnum;
use App\Enums\CycleAsaasEnum;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\View\View;

class PlanController extends Controller
{
    protected $model;
    protected $request;

    public function __construct(Plan $plan, Request $request)
    {
        $this->middleware('can:admin');

        $this->model = $plan;
        $this->request = $request;
    }

    public function index(): View
    {
        return view($this->request->route()->getName());
    }

    public function loadDatatable(): JsonResponse
    {
        $plans = $this->model
            ->select([
                'plans.id',
                'plans.name',
                'plans.value',
                'plans.cycle',
                'plans.created_at',
                'plans.is_active',
                'plans.billing_type',
            ]);

        return DataTables::of($plans)
            ->addColumn('checkbox', function ($plan) {
                return view('panel.plans.local.index.datatable.checkbox', compact('plan'));
            })
            ->editColumn('id', function ($plan) {
                return view('panel.plans.local.index.datatable.id', compact('plan'));
            })
            ->editColumn('cycle', function ($plan) {
                return CycleAsaasEnum::from($plan->cycle)->getName();
            })
            ->filterColumn('cycle', function ($query, $keyword) {
                $matchingCycles = collect(CycleAsaasEnum::cases())
                    ->filter(fn($enum) => str_contains($enum->getName(), $keyword))
                    ->pluck('value')
                    ->toArray();

                $query->whereIn('cycle', $matchingCycles);
            })
            ->editColumn('billing_type', function ($plan) {
                return BillingTypeAsaasEnum::from($plan->billing_type)->getName();
            })
            ->filterColumn('billing_type', function ($query, $keyword) {
                $matchingBillingTypes = collect(BillingTypeAsaasEnum::cases())
                    ->filter(fn($enum) => str_contains($enum->getName(), $keyword))
                    ->pluck('value')
                    ->toArray();

                $query->whereIn('billing_type', $matchingBillingTypes);
            })
            ->editColumn('created_at', function ($plan) {
                return $plan->created_at ? date('d/m/Y H:i:s', strtotime($plan->created_at)) : 'Sem data';
            })
            ->filterColumn('created_at', function ($query, $value) {
                $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y %H:%i:%s') like ?", ["%$value%"]);
            })
            ->editColumn('is_active', function ($item) {
                return view('panel.plans.local.index.datatable.is_active', compact('item'));
            })
            ->addColumn('action', function ($plan) {
                $loggedId = auth()->user()->id;

                return view('panel.plans.local.index.datatable.action', compact('plan', 'loggedId'));
            })
            ->toJson();
    }

    public function create(): View
    {
        $plan = $this->model;

        return view('panel.plans.local.index.modals.create', compact('plan'));
    }

    public function store(): JsonResponse
    {
        $data = $this->request->only([
            'name',
            'value',
            'description',
            'cycle',
            'is_active',
            'is_best_seller',
            'billing_type',
            'free_for_days',
        ]);

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'min:0'],
            'description' => ['nullable', 'string'],
            'name' => ['required', 'string'],
            'is_active' => ['nullable', 'string'],
            'is_best_seller' => ['nullable', 'string'],
            'billing_type' => ['string'],
            'free_for_days' => ['integer'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        }

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['is_best_seller'] = isset($data['is_best_seller']) ? 1 : 0;

        $plan = $this->model->create($data);

        if ($this->request->filled('benefits')) {
            foreach ($this->request->benefits as $benefit) {
                $plan->benefits()->create(['description' => $benefit]);
            }
        }

        if ($plan) {
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
        $plan = $this->model->find($id);

        return view('panel.plans.local.index.modals.edit', compact("plan"));
    }

    public function duplicate(): View
    {
        $plan = $this->model->find($this->request->id);

        return view('panel.plans.local.index.modals.duplicate', compact('plan'));
    }

    public function update($id): JsonResponse
    {
        $plan = $this->model->find($id);

        if ($plan) {
            $data = $this->request->only([
                'name',
                'value',
                'description',
                'cycle',
                'is_active',
                'is_best_seller',
                'billing_type',
                'free_for_days',
            ]);

            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'value' => ['required', 'string', 'min:0'],
                'description' => ['nullable', 'string'],
                'name' => ['required', 'string'],
                'is_active' => ['nullable', 'string'],
                'is_best_seller' => ['nullable', 'string'],
                'billing_type' => ['string'],
                'free_for_days' => ['integer'],
            ]);

            if (count($validator->errors()) > 0) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->errors(),
                ]);
            }

            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            $data['is_best_seller'] = isset($data['is_best_seller']) ? 1 : 0;

            $plan->update($data);

            $plan->benefits()->delete();

            if ($this->request->filled('benefits') && count($this->request->input('benefits')) > 0 && !is_null($this->request->input('benefits')[0])) {
                foreach ($this->request->benefits as $benefit) {
                    $plan->benefits()->create(['description' => $benefit]);
                }
            }

            if ($plan) {
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
        $plan = $this->model->find($this->request->id);

        return view('panel.plans.local.index.modals.delete', compact("plan"));
    }

    public function destroy(): JsonResponse
    {
        $plan = $this->model->find($this->request->id);

        if ($plan) {
            $delete = $plan->delete();

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

        return view('panel.plans.local.index.modals.remove-all', compact("itens"));
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
}
