<?php

namespace App\Http\Controllers\Auth;

use App\Enums\YouCastErrorCode;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Plan;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\Cpf;
use App\Services\AppIntegration\CustomerService;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function showRegistrationForm(int $planId = null)
    {
        $planId = $planId ? $planId : '';

        $plans = Plan::select(['id', 'name', 'value'])
            ->where('is_active', 1)
            ->get();

        return view('auth.register', compact('plans', 'planId'));
    }

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data): ValidationValidator
    {
        return Validator::make($data, [
            'id' => ['integer'],
            'name' => ['required', 'string'],
            'document' => ['required', new \App\Rules\Cpf()],
            'mobile' => ['required', 'string'],
            'birthdate' => ['date'],
            'email' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($data) {
                    if (($data['source'] ?? null) === 'temporarily') {
                        return;
                    }

                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail('O campo email deve conter um endereço de email válido.');
                    }

                    if (\App\Models\Customer::where('email', $value)->exists()) {
                        $fail('O email já está em uso.');
                    }
                }
            ],
            'login' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($data) {
                    if (($data['source'] ?? null) === 'temporarily') {
                        return;
                    }

                    if (\App\Models\Customer::where('login', $value)->exists()) {
                        $fail('O login já está em uso.');
                    }
                }
            ],
            'password' => [
                function ($attribute, $value, $fail) use ($data) {
                    if (($data['source'] ?? null) !== 'temporarily' && empty($value)) {
                        $fail('O campo senha é obrigatório.');
                    }
                },
                'string',
                'confirmed',
            ],
        ]);
    }

    protected function create(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request, CustomerService $customerService)
    {
        $this->validator($request->all())->validate();

        $data = $request->only(['login', 'name', 'document', 'mobile', 'birthdate', 'email']);

        if (!session()->has('customerData')) {
            $externalCustomer = $this->verifyCustomerInYouCast($customerService);

            if ($externalCustomer instanceof RedirectResponse) {
                return $externalCustomer;
            }
        }

        try {
            $customer = Customer::updateOrCreate(
                ['login' => $data['login']],
                $data
            );
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                $errorMessage = $e->getMessage();

                if (strpos($errorMessage, 'customers_document_unique') !== false) {
                    return back()
                        ->withInput()
                        ->withErrors(['document' => 'O CPF/CNPJ informado já está cadastrado.']);
                }

                if (strpos($errorMessage, 'customers_login_unique') !== false) {
                    return back()
                        ->withInput()
                        ->withErrors(['login' => 'O login informado já está em uso.']);
                }
            }

            Log::error("RegisterController - linha - 138: {$e->getMessage()}");

            return back()
                ->withInput()
                ->withErrors(['error' => 'Ocorreu um erro ao processar o registro. Tente novamente mais tarde.']);
        }

        toastr()->success('Criado com sucesso, faça o login!');

        session()->forget('customerData');

        return $this->registered($request, $customer)
            ?: redirect($this->redirectPath());
    }

    private function verifyCustomerInYouCast(CustomerService $customerService): mixed
    {
        $login = request()->login;
        $password = request()->password;

        $externalCustomer = $customerService->findExternalCustomerByLogin($login, $password);

        if ($externalCustomer) {

            $authenticateExternalCustomer = $customerService->authenticateExternalCustomer($login, $password);

            $customerData = $externalCustomer['customer'];

            if ($authenticateExternalCustomer) {
                session([
                    'authenticate' => true,
                    'customerData' => $customerData,
                ]);

                return redirect()->route('login')->with([
                    'info' => 'Usuário localizado na Agro Play. Efetue o login ou recupere a senha.',
                ]);
            }

            $data = request()->only(['login', 'name', 'document', 'mobile', 'birthdate', 'email']);
            $customer = Customer::create([
                'viewers_id' => $customerData['viewers_id'],
                'login' => $customerData['login'],
                'name' => $customerData['name'],
                'email' => $customerData['email']
            ]);

            return redirect()->route('login')->with([
                'error' => 'Usuário localizado na Agro Play. Login ou senha incorretos. Tente novamente ou clique em recuperar senha informando o email cadastrado: ' . $customerData['email'],
            ]);
        }

        return null;
    }
}
