<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use App\Services\AppIntegration\CustomerService;
use App\Services\AppIntegration\UserService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username(): string
    {
        return 'login';
    }

    protected function redirectTo(): string
    {
        $user = auth()->user();
        return $user->access_id == 1 ? route('panel.main.index-user') : RouteServiceProvider::HOME;
    }

    public function login(Request $request, UserService $userService, CustomerService $customerService)
    {
        $this->validateLogin($request);

        $login = $request->input('login');
        $password = $request->input('password');

        $localUser = $userService->findUserByLogin($login);

        if (!$localUser) {
            $externalCustomer = $customerService->findExternalCustomerByLogin($login, $password);

            if ($externalCustomer) {

                $authenticateExternalCustomer = $customerService->authenticateExternalCustomer($login, $password);

                $customerData = $externalCustomer['customer'];

                if ($authenticateExternalCustomer) {
                    session([
                        'authenticate' => true,
                        'customerData' => $customerData,
                    ]);

                    toastr()
                        ->info('Usuário localizado na Agro Play. Complete o registro.', 'Informações');

                    return redirect()->route('register');
                }

                $data = $request->only(['login', 'name', 'document', 'mobile', 'birthdate', 'email']);
                $customer = Customer::create([
                    'viewers_id' => $customerData['viewers_id'],
                    'login' => $customerData['login'] ?? '',
                    'name' => $customerData['name'] ?? '',
                    'email' => $customerData['email'] ?? ''
                ]);

                toastr()
                    ->error('Usuário localizado na Agro Play. Login ou senha incorretos. Tente novamente ou clique em recuperar senha informando o email cadastrado: ' . $customerData['email'] .  '', 'Atenção');

                return redirect()->route('login');
            }

            session([
                'customerData' => [
                    'source' => '',
                    'name' => '',
                    'email' => '',
                    'login' => $login ?? '',
                    'password' => $password ?? '',
                ],
            ]);

            toastr()->warning('Usuário não encontrado no sistema. Faça o registro.', 'Alerta');

            return redirect()->route('register');
        }

        if (Auth::validate(['login' => $login, 'password' => $password])) {
            if ((isset($localUser->customer) && is_null($localUser->customer->document)) && $localUser->access_id === 1) {
                session([
                    "customerData" => [
                        'source' => 'temporarily',
                        'name' => $localUser->name,
                        'email' => $localUser->email,
                        'login' => $localUser->login,
                        'password' => $password,
                    ]
                ]);

                toastr()->warning('Usuário localizado no sistema. Selecione um plano e complete o registro.', 'Informações');

                return redirect()->route('register');
            }

            if (auth()->attempt(['login' => $login, 'password' => $password])) {
                if ($localUser->access_id === 1) {
                    return redirect()->route('panel.main.index-user');
                }
            }

            return redirect()->route('panel.main.index');
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
