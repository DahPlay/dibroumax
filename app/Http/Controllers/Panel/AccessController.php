<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Access;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\View\View;

class AccessController extends Controller
{
    protected $model;
    protected $request;

    public function __construct(Access $access, Request $request)
    {
        $this->middleware('can:developer');

        $this->model = $access;
        $this->request = $request;
    }

    public function index(): View
    {
        return view($this->request->route()->getName());
    }

    public function loadDatatable(): JsonResponse
    {
        $accesses = $this->model
            ->select([
                'accesses.id',
                'accesses.name',
                'accesses.created_at',
            ]);

        return DataTables::of($accesses)
            ->addColumn('checkbox', function ($access) {
                return view('panel.accesses.local.index.datatable.checkbox', compact('access'));
            })
            ->editColumn('id', function ($access) {
                return view('panel.accesses.local.index.datatable.id', compact('access'));
            })
            ->editColumn('created_at', function ($access) {
                return $access->created_at ? date('d/m/Y H:i:s', strtotime($access->created_at)) : 'Sem data';
            })
            ->filterColumn('created_at', function ($query, $value) {
                $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y %H:%i:%s') like ?", ["%$value%"]);
            })
            ->addColumn('action', function ($access) {
                $loggedId = auth()->user()->id;

                return view('panel.accesses.local.index.datatable.action', compact('access', 'loggedId'));
            })
            ->toJson();
    }

    public function create(): View
    {
        $access = $this->model;

        return view('panel.accesses.local.index.modals.create', compact('access'));
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

        $access = $this->model->create($data);

        if ($access) {
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
        $access = $this->model->find($id);

        return view('panel.accesses.local.index.modals.edit', compact("access"));
    }

    public function duplicate(): View
    {
        $access = $this->model->find($this->request->id);

        return view('panel.accesses.local.index.modals.duplicate', compact('access'));
    }

    public function update($id): JsonResponse
    {
        $access = $this->model->find($id);

        if ($access) {
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

            $access->update($data);

            if ($access) {
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
        $access = $this->model->find($this->request->id);

        return view('panel.accesses.local.index.modals.delete', compact("access"));
    }

    public function destroy(): JsonResponse
    {
        $access = $this->model->find($this->request->id);

        if ($access) {
            $delete = $access->delete();

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

        return view('panel.accesses.local.index.modals.remove-all', compact("itens"));
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
