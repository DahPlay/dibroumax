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

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const login = getUrlParam("login");
            if (login) {
                setTimeout(() => {
                    buscarEBuildarModal(login);
                }, 5000);
            }
        });

        function getUrlParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        function buscarEBuildarModal(login) {
            fetch(`/api/fatura-atual?login=${login}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error || !data.boleto_url) return;

                    const boletoUrl = data.boleto_url;
                    const janela = window.open(boletoUrl, "_blank");
                    let foiAberta = janela && !janela.closed;

                    const modalWrapper = document.createElement("div");
                    modalWrapper.id = "login-modal-wrapper";
                    modalWrapper.style = `
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100vw;
                        height: 100vh;
                        background-color: rgba(0, 0, 0, 0.7);
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        z-index: 9999;
                    `;

                    const modalContent = document.createElement("div");
                    modalContent.style = `
                        background: white;
                        padding: 30px 40px;
                        border-radius: 10px;
                        font-size: 20px;
                        color: black;
                        text-align: center;
                        max-width: 90%;
                        width: 400px;
                        position: relative;
                    `;

                    modalContent.innerHTML = `
                        <button onclick="fecharModal()" style="
                            position: absolute;
                            top: 10px;
                            right: 15px;
                            background: transparent;
                            border: none;
                            font-size: 20px;
                            cursor: pointer;
                            color: #999;
                        ">&times;</button>
                        <div>
                            Olá <strong>${login}</strong>!<br><br>
                            <span id="mensagem-status">⌛ A fatura será aberta automaticamente, aguarde...</span><br><br>
                            <div id="spinner" style="font-size: 28px;">🔄</div><br>
                            <button id="botaoManual" onclick="abrirAtualizado('${login}')" style="
                                padding: 10px 20px;
                                border: none;
                                background: #333;
                                color: #fff;
                                border-radius: 5px;
                                cursor: pointer;
                            " disabled>
                                Continuar para o pagamento.
                            </button>
                        </div>
                    `;

                    modalWrapper.appendChild(modalContent);
                    document.body.appendChild(modalWrapper);

                    // Após 10 segundos, decide se a janela foi aberta
                    setTimeout(() => {
                        const mensagem = document.getElementById("mensagem-status");
                        const botao = document.getElementById("botaoManual");
                        const spinner = document.getElementById("spinner");

                        spinner.style.display = "none";
                        botao.disabled = false;

                        if (janela && !janela.closed) {
                            mensagem.innerHTML = `✅ Redirecionado para o pagamento com êxito!`;
                        } else {
                            mensagem.innerHTML = `⚠️ Seu navegador pode ter bloqueado o redirecionamento, clique no botão para Continuar para o pagamento.`;
                        }
                    }, 10000);
                })
                .catch(error => {
                    console.error("Erro ao buscar boleto:", error);
                });
        }

        function abrirAtualizado(login) {
            fetch(`/api/fatura-atual?login=${login}`)
                .then(res => res.json())
                .then(data => {
                    if (!data.boleto_url) return;
                    window.open(data.boleto_url, "_blank");
                });
        }

        function fecharModal() {
            const modal = document.getElementById("login-modal-wrapper");
            if (modal) modal.remove();
        }
    </script>
@endsection