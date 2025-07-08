<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Access;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $model;
    protected $request;

    public function __construct(User $user, Request $request)
    {
        $this->model = $user;
        $this->request = $request;
    }

    public function index(): View
    {
        return view($this->request->route()->getName());
    }

    public function loadDatatable(): JsonResponse
    {
        $users = $this->model->with(['access'])
            ->select([
                'users.id',
                'users.name',
                'users.login',
                'users.email',
                'users.created_at',
                'users.access_id',
            ])
            ->when(auth()->user()->id !== 3, function ($query) {
                $query->where('access_id', '<>', 3);
            });

        return DataTables::of($users)
            ->addColumn('checkbox', function ($user) {
                return view('panel.users.local.index.datatable.checkbox', compact('user'));
            })
            ->editColumn('id', function ($user) {
                return view('panel.users.local.index.datatable.id', compact('user'));
            })
            ->editColumn('created_at', function ($user) {
                return $user->created_at ? date('d/m/Y H:i:s', strtotime($user->created_at)) : 'Sem data';
            })
            ->editColumn('access.name', function ($user) {
                return view('panel.users.local.index.datatable.access', compact('user'));
            })
            ->filterColumn('created_at', function ($query, $value) {
                $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y %H:%i:%s') like ?", ["%$value%"]);
            })
            ->addColumn('action', function ($user) {
                $loggedId = auth()->user()->id;

                return view('panel.users.local.index.datatable.action', compact('user', 'loggedId'));
            })
            ->make();
    }

    public function create(): View
    {
        $user = $this->model;

        $accesses = Access::select(['id', 'name'])->get();

        return view('panel.users.local.index.modals.create', compact('user', 'accesses'));
    }

    public function store(): JsonResponse
    {
        $data = $this->request->only([
            'photo',
            'name',
            'login',
            'email',
            'password',
            'password_confirmation',
            'access_id',
        ]);

        $validator = Validator::make($data, [
            'photo' => 'image|mimes:jpeg,jpg,png|max:500',
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'access_id' => ['required', 'integer']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        }

        if ($this->request->hasFile('photo')) {
            $data["photo"] = $this->request->file('photo')->store('avatars', 'public');
        }

        $user = $this->model->create($data);

        if ($user) {
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
        $user = $this->model->find($id);

        $accesses = Access::select(['id', 'name'])->get();

        return view('panel.users.local.index.modals.edit', compact("user", "accesses"));
    }

    public function update($id): JsonResponse
    {
        $user = $this->model->find($id);

        if ($user) {
            $data = $this->request->only([
                'photo',
                'name',
                'login',
                'email',
                'password',
                'password_confirmation',
            ]);

            $validator = Validator::make($data, [
                'photo' => 'image|mimes:jpeg,jpg,png|max:500',
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:200'],
            ]);

            if ($user->email != $this->request->email) {
                $hasEmail = $this->model->where('email', $this->request->email)->get();

                if (count($hasEmail) == 0) {
                    $user->email = $this->request->email;
                } else {
                    $validator->errors()->add('email', __('validation.unique', [
                        'attribute' => 'email',
                    ]));
                }
            }

            if (!empty($this->request->password)) {
                if (strlen($this->request->password) >= 4) {
                    if ($this->request->password === $this->request->password_confirmation) {
                        $data['password'] = Hash::make($this->request->password);
                    } else {
                        $validator->errors()->add('password', __('validation.confirmed', [
                            'attribute' => 'password',
                        ]));
                    }
                } else {
                    $validator->errors()->add('password', __('validation.min.string', [
                        'attribute' => 'password',
                        'min' => 4
                    ]));
                }
            } else {
                $data['password'] = $user->password;
            }

            if (count($validator->errors()) > 0) {
                return response()->json([
                    'status' => 400,
                    'errors' => $validator->errors(),
                ]);
            }

            if ($this->request->hasFile('photo')) {
                if ($user->photo) {
                    $file_path_photo = public_path('storage/' . $user->photo);

                    if (file_exists($file_path_photo) && $user->photo != "avatars/default.png") {
                        unlink($file_path_photo);
                    }
                }

                $data["photo"] = $this->request->file('photo')->store('avatars', 'public');
            }

            $user->update($data);

            if ($user) {
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
        $user = $this->model->find($this->request->id);

        return view('panel.users.local.index.modals.delete', compact("user"));
    }

    public function destroy(): JsonResponse
    {
        $user = $this->model->find($this->request->id);

        if ($user) {
            if ($user->photo && $user->photo !== 'avatars/default.png') {
                $file_path_photo = storage_path('app/public/' . $user->photo);

                if (file_exists($file_path_photo)) {
                    unlink($file_path_photo);
                }
            }

            $delete = $user->delete();

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

        return view('panel.users.local.index.modals.remove-all', compact("itens"));
    }

    public function destroyAll(): JsonResponse
    {
        foreach (session()->get('ids') as $item) {
            $item = $this->model->find($item["id"]);

            if ($item) {
                if ($item->photo != "avatars/default.png") {
                    $file_path_photo = public_path('storage/') . $item->photo;

                    if (file_exists($file_path_photo)) {
                        unlink($file_path_photo);
                    }
                }

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

    public function removeImage(): JsonResponse
    {
        $user = $this->model->find($this->request->id);

        if ($user) {
            if ($user->photo) {
                $file_path_photo = public_path('storage/') . $user->photo;

                if (file_exists($file_path_photo) && $user->photo != "avatars/default.png") {
                    unlink($file_path_photo);
                }

                $user->photo = "avatars/default.png";
                $user->save();

                return response()->json([
                    'status' => '200',
                    'message' => 'Imagem removida com sucesso!'
                ]);
            } else {
                return response()->json([
                    'status' => '400',
                    'errors' => [
                        'message' => ['Erro ao tentar remover a imagem!']
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
