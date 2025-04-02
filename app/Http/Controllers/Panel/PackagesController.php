<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageRequest;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class PackagesController extends Controller
{
    public function __construct (public Package $model, public Request $request)
    {
        $this->middleware('can:developer');
    }

    public function index (): View
    {
        return view($this->request->route()->getName());
    }

    public function loadDatatable (): JsonResponse
    {
        $packages = $this->model
            ->get();

        return DataTables::of($packages)
            ->addColumn('checkbox', function ($package) {
                return view('panel.packages.local.index.datatable.checkbox', compact('package'));
            })
            ->editColumn('id', function ($package) {
                return view('panel.packages.local.index.datatable.id', compact('package'));
            })
            ->editColumn('created_at', function ($package) {
                return $package->created_at ? date('d/m/Y H:i:s', strtotime($package->created_at)) : 'Sem data';
            })
            ->editColumn('is_active', function ($item) {
                return view('panel.packages.local.index.datatable.is_active', compact('item'));
            })
            ->addColumn('action', function ($package) {
                $loggedId = auth()->user()->id;

                return view('panel.packages.local.index.datatable.action', compact('package', 'loggedId'));
            })
            ->toJson();
    }

    public function create (): View
    {
        $package = new Package();
        return view('panel.packages.local.index.modals.create', compact('package'));
    }

    public function store (PackageRequest $request): RedirectResponse
    {
        $isActive = match ($request->is_active) {
            'on' => true,
            0 => false,
        };

        $data = $request->validated();

        $data['is_active'] = $isActive;

        $model = Package::create($data);

        if ($model) {
            toastr('Salvo!');
            return redirect()->route('panel.packages.index');
        }
        toastr('Tente novamente ou entre em contato com o administrador do sistema!');
        return redirect()->route('panel.packages.index');
    }

    public function delete ($id): View
    {
        $package = $this->model->find($id);

        return view('panel.packages.local.index.modals.delete', compact("package"));
    }

    public function destroy($id): RedirectResponse
    {
        $this->model->find($id)->delete();
        toastr('Apagado!');
        return redirect()->route('panel.packages.index');
    }

    public function edit($id): View
    {
        $plan = $this->model->find($id);

        return view('panel.plans.local.index.modals.edit', compact("Package"));
    }


    public function update($id): JsonResponse
    {
        dd('update');;
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





    public function deleteAll(): View
    {
        dd('destroyallRender');
        $itens = $this->request->checkeds;

        session()->put('ids', $itens);

        return view('panel.plans.local.index.modals.remove-all', compact("itens"));
    }

    public function destroyAll(): JsonResponse
    {
        dd('destroyall');
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
