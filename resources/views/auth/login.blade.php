@extends('auth.template.index')

@section('content')


    <div class="background-login col-6 d-none d-md-flex"
        style="background-image: url('/Auth-Panel/dist/img/{{ config('custom.background_login_image') }}')"></div>
    <div class="login-box login-page col-12 col-md-6 p-0"
        style="background-color: {{ config('custom.background_login_color') }};">


        @if (count($errors) > 0)
            <script>
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Atenção ao(s) seguinte(s) erro(s):',
                    position: 'topRight',
                    body: [
                        @foreach ($errors->all() as $error)
                            "<li>{{ $error }}</li>",
                        @endforeach
                                                                                                        ]
                })
            </script>
        @endif

        <div class="card col p-0">
            <div class="card-body d-flex flex-column login-card-body p-0">
                <div class="card mb-5">
                    <div class="card-body text-center">
                        @php
                            $baseUrl = config('app.url');
                            if (app()->environment('local')) {
                                $baseUrl .= ':8000';
                            }
                        @endphp

                        <div class="social-auth-links text-center mb-3">
                            <p style="color: {{ config('custom.text_color_conta') }};">
                                Voltar para
                                <a href="{{ $baseUrl }}" style="color: {{ config('custom.text_color_cadastre') }};">Home</a>
                            </p>
                        </div>
                        <div class="d-flex justify-content-center">
                            <p style=" color: {{ config('custom.text_color_acessar') }};">Acessar
                                {{config('custom.project_name')}}
                            </p>
                            <i class="fa fa-arrow-down ml-2 animate__animated animate__bounce"
                                style=" color: {{ config('custom.text_color_acessar') }};"></i>
                        </div>

                        <a href="{{ config('custom.portal_link') }}" target="_blank">
                            <img src="{{ config('custom.logo_1') }}" style="width: 140px;"
                                alt="{{config('custom.project_name')}}">
                        </a>
                    </div>
                </div>


                <h3 class="login-box-msg" style=" color: {{ config('custom.text_color_gerenciar') }};">Gerenciar Conta</h3>

                <form action="{{ route('login') }}" method="post">
                    @csrf

                    <div class="input-group mb-2 d-flex flex-column">
                        <label for="login"></label>
                        <input type="text" @error('login') is-invalid @enderror value="{{ old('login') ?? '' }}"
                            name="login" id="login" class="form-control w-100" placeholder="Usuário">

                        @error('login')
                            <span class="text-danger position-relative" style="top: 10px;">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="input-group mb-2 d-flex flex-column">
                        <label for="password"></label>
                        <input type="password" @error('password') has-error @enderror value="{{ old('password') ?? '' }}"
                            name="password" id="password" class="form-control w-100" placeholder="Senha"
                            style="min-height: 40px">

                        @error('password')
                            <span class="text-danger position-relative" style="top: 10px;">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <button type="submit" class="acess-button"
                                style="background-color: {{ config('custom.button_color_entrar') }}; color: {{ config('custom.button_text_color_entrar') }};">Entrar</button>
                        </div>

                        <div class="col-12 d-flex align-items-center justify-content-center">
                            {{-- {{ route('password.email') }} --}}
                            <a href="{{ route('password.request') }}" class="password-button text-center border text-black"
                                style="background-color: {{ config('custom.button_color_senha') }}; color: {{ config('custom.button_text_color_senha') }}; border: {{ config('custom.button_color_senha') }}!important;">
                                <i class="fab fa-lock mr-2"></i> Esqueci minha senha
                            </a>
                        </div>
                    </div>

                    <div class="">
                        <div class="col-12">
                            <div class="social-auth-links text-center mb-3">
                                <p style=" color: {{ config('custom.text_color_conta') }};">Não tem uma conta? <a
                                        href="{{ config('app.url') . '#planos' }}" class=""
                                        style=" color: {{ config('custom.text_color_cadastre') }};">Cadastre-se</a></p>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="login-logo position-absolute">
            <a href="{{ route('login') }}">
                <img src="{{ config('custom.logo_2') }}" alt="">
            </a>
        </div>

        <!-- @if (session('redirect_boleto_url'))
                <div style="background: #fff3cd; color: #856404; padding: 15px; border: 1px solid #ffeeba; margin-bottom: 20px;">
                    Seu cadastro foi realizado com sucesso!<br>
                    Você será redirecionado para a **fatura** em alguns segundos...
                </div>

                <script>
                    setTimeout(function () {
                        const url = "{{ session('redirect_boleto_url') }}";
                        const newWindow = window.open(url, '_blank');
                        if (newWindow) {
                            newWindow.focus();
                        }
                    }, 5000);
                </script>

            @endif -->

        <!-- @php
                use App\Models\Customer;
                use App\Models\Order;

                $login = session('login');
                $customer = Customer::where('login', $login)->first();

                if ($customer) {
                    $order = Order::where('customer_id', $customer->id)->first();

                    if ($order && $order->payment_asaas_id) {
                        // Executa somente quando payment_asaas_id tiver valor
                        session()->flash('redirect_boleto_url', 'https://sandbox.asaas.com/i/' . $order->payment_asaas_id); // ou $order->boleto_url
                    } else {
                        // Opcional: mensagem de aguarde ou debug
                        echo "Aguardando geração do payment_asaas_id...";
                    }
                } else {
                    echo "Cliente não encontrado.";
                }
            @endphp -->

        <div id="mensagem-pagamento"
            style="background: #fff3cd; color: #856404; padding: 15px; border: 1px solid #ffeeba; margin-bottom: 20px;">
            Estamos gerando seu boleto, isso pode levar alguns segundos...
        </div>

        <script>
            let tentativas = 0;
            const maxTentativas = 10; // agora tenta até 10 vezes
            const intervalo = 5000; // 5 segundos

            const verificarPagamento = () => {
                fetch('/verifica-pagamento')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.open(data.redirect_url, '_blank');
                            document.getElementById('mensagem-pagamento').innerText = "Redirecionando para o pagamento...";
                        } else {
                            tentativas++;
                            if (tentativas < maxTentativas) {
                                setTimeout(verificarPagamento, intervalo);
                            } else {
                                document.getElementById('mensagem-pagamento').innerText =
                                    "Não foi possível gerar o link agora. Acesse sua conta ou verifique seu e-mail para visualizar sua assinatura.";
                            }
                        }
                    })
                    .catch((error) => {
                        console.error("Erro na requisição:", error);
                        // Só exibe erro se for falha real de rede ou servidor
                        document.getElementById('mensagem-pagamento').innerText =
                            "Erro de conexão. Tente novamente mais tarde.";
                    });
            };

            // Primeira tentativa
            setTimeout(verificarPagamento, intervalo);
        </script>




    </div>


@endsection