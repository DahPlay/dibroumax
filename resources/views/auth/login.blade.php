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
    window.onload = function () {
        const login = getUrlParam("login");
        if (login) {
            exibirModalInicial(login);

            // Após 3 segundos, tenta buscar e abrir automaticamente
            setTimeout(() => {
                buscarEabrirFatura(login);
            }, 3000);

            // Após 10 segundos, permite o botão manual
            setTimeout(() => {
                habilitarBotaoManual(login);
            }, 10000);
        }
    };

    function getUrlParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    function exibirModalInicial(login) {
        const modalHtml = `
            <div id="login-modal-wrapper" style="
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
            ">
                <div style="
                    background: white;
                    padding: 30px 40px;
                    border-radius: 10px;
                    font-size: 18px;
                    color: black;
                    text-align: center;
                    max-width: 90%;
                    width: 400px;
                    position: relative;
                ">
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
                        <p>Olá <strong>${login}</strong>!</p>
                        <p id="mensagem-status">🔄 Aguarde, sua fatura será aberta automaticamente...</p>
                        <div id="spinner" style="margin: 20px auto;">
                            <div style="
                                border: 4px solid #f3f3f3;
                                border-top: 4px solid #333;
                                border-radius: 50%;
                                width: 30px;
                                height: 30px;
                                animation: spin 1s linear infinite;
                                margin: 0 auto;
                            "></div>
                        </div>
                        <button id="botao-manual" disabled style="
                            padding: 10px 20px;
                            border: none;
                            background: #ccc;
                            color: #666;
                            border-radius: 5px;
                            cursor: not-allowed;
                            margin-top: 20px;
                        ">
                            Clique aqui para abrir manualmente
                        </button>
                    </div>
                </div>
            </div>

            <style>
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            </style>
        `;

        const modal = document.createElement("div");
        modal.innerHTML = modalHtml;
        document.body.appendChild(modal);
    }

    function buscarEabrirFatura(login) {
        fetch(`/api/fatura-atual?login=${login}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Erro ao buscar fatura");
                }
                return response.json();
            })
            .then(data => {
                if (!data.boleto_url) return;

                const janela = window.open(data.boleto_url, "_blank");
                const foiAberta = janela && !janela.closed;

                if (foiAberta) {
                    atualizarStatus("✅ Fatura aberta com êxito!");
                }
            })
            .catch(error => {
                console.error("Erro ao buscar ou abrir fatura:", error);
            });
    }

    function habilitarBotaoManual(login) {
        const botao = document.getElementById("botao-manual");
        const spinner = document.getElementById("spinner");
        const mensagem = document.getElementById("mensagem-status");

        if (spinner) spinner.remove();
        if (mensagem) {
            mensagem.textContent =
                "⚠️ Seu navegador pode ter bloqueado a abertura da fatura, clique no botão para gerar manualmente.";
        }

        if (botao) {
            botao.disabled = false;
            botao.style.background = "#333";
            botao.style.color = "#fff";
            botao.style.cursor = "pointer";

            botao.onclick = function () {
                fetch(`/api/fatura-atual?login=${login}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.boleto_url) {
                            window.open(data.boleto_url, "_blank");
                            atualizarStatus("✅ Fatura aberta com êxito!");
                        }
                    });
            };
        }
    }

    function atualizarStatus(msg) {
        const mensagem = document.getElementById("mensagem-status");
        const spinner = document.getElementById("spinner");
        if (mensagem) mensagem.textContent = msg;
        if (spinner) spinner.remove();
    }

    function fecharModal() {
        const modal = document.getElementById("login-modal-wrapper");
        if (modal) modal.remove();
    }

    console.log("🟢 Script carregado");
</script>





@endsection