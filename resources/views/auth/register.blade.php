@extends('auth.template.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('Auth-Panel/dist/css/front/front.css') }}">
@endsection

@section('content')
    <div class="register-box flex-column">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-register m-auto">
            <div class="card-body-register login-card-body">
                <div class="login-logo">
                    <a href="{{ route('login') }}">
                        <img src="{{ asset('Auth-Panel/dist/img/logo.svg') }}" alt="">
                    </a>
                </div>

                <p class="subtitle-register">Crie sua conta e aproveite todo nosso conteúdo!</p>

                <form action="{{ route('register') }}" method="post">
                    @csrf

                    <input type="hidden" name="source" id="source" class="form-control" required
                        value="{{ old('source', session('customerData')['source'] ?? '') }}"
                        {{ isset(session('customerData')['source']) ? 'readonly' : '' }}>

                    <div class="input-group mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="title-input mb-0" for="plan">Planos *</label>
                            <button type="button" class="btn btn-primary btn-view" data-toggle="modal"
                                data-target="#modalPlanos">Ver
                                planos</button>
                        </div>

                        <select id="plan_id" id="plan_id" class="form-control" name="plan_id" required>
                            <option value="">Selecione...</option>
                            @foreach ($plans as $plan)
                                <option value='{{ $plan->id }}' @selected($plan->id == $planId)>
                                    {{ $plan->name . ' - ' . number_format($plan->value, 2, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <label class="title-input" for="usuario">Digite seu usuário *</label>
                        <input type="text" name="login" id="usuario" class="form-control" placeholder="Usuário *"
                            required value="{{ old('login', session('customerData')['login'] ?? '') }}">
                    </div>

                    @error('login')
                        <span class="text-danger">{{ $message }}</span>
                        <hr>
                    @enderror

                    <div class="input-group mb-3">
                        <label class="title-input" for="name">Qual seu nome completo *</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="Digite seu nome completo *" required
                            value="{{ old('name', session('customerData')['name'] ?? '') }}">
                    </div>

                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        <hr>
                    @enderror

                    <div class="input-group mb-3">
                        <label class="title-input" for="document">CPF *</label>
                        <input type="text" @error('document') has-error @enderror value="{{ old('document') ?? '' }}"
                            name="document" id="document" class="form-control" placeholder="Digite seu cpf *" required>
                    </div>

                    @error('document')
                        <span class="text-danger">{{ $message }}</span>
                        <hr>
                    @enderror

                    <div class="input-group mb-3">
                        <label class="title-input" for="mobile">Digite seu número *</label>
                        <input type="text" @error('mobile') has-error @enderror value="{{ old('mobile') ?? '' }}"
                            name="mobile" id="mobile" class="form-control" placeholder="(00) 00000-0000" required>
                    </div>

                    @error('mobile')
                        <span class="text-danger">{{ $message }}</span>
                        <hr>
                    @enderror

                    <div class="input-group mb-3">
                        <label class="title-input" for="email">Digite seu email *</label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="meuemail@mail.com" required
                            value="{{ old('email', session('customerData')['email'] ?? '') }}">
                    </div>

                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        <hr>
                    @enderror

                    @if (
                        !session()->has('customerData') ||
                            (session()->has('customerData') && session('customerData')['source'] !== 'temporarily'))
                        <div class="input-group mb-3">
                            <label class="title-input" for="password">Crie sua senha *</label>
                            <input type="password" @error('password') has-error @enderror
                                value="{{ session()->has('authenticate') ? session('customerData')['password'] : '' }}"
                                name="password" id="password" class="form-control" placeholder="Crie uma senha forte"
                                required {{ session()->has('authenticate') ? 'readonly' : '' }}>
                            {{-- <div class="tips-password">
                            <p>Use no <strong>mínimo 6 caracteres</strong></p>
                            <p>* 1 letra maiúscula</p>
                            <p>* 1 número</p>
                            <p>* 1 carácter especial ex: @#$</p>
                        </div> --}}
                        </div>

                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            <hr>
                        @enderror

                        <div class="input-group mb-3">
                            <label class="title-input" for="password_confirmation">Confirmação de senha *</label>
                            <input type="password" @error('password_confirmation') has-error @enderror
                                value="{{ old('password_confirmation') ?? '' }}" name="password_confirmation"
                                id="password_confirmation" class="form-control" placeholder="Repita sua senha" required>
                        </div>

                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                            <hr>
                        @enderror
                    @endif

                    {{-- <div class="input-group row-input">
                        <input type="checkbox" id="confirm-terms" required>
                        <span><strong>Aceito</strong> receber novidades, ofertas especiais e outras informações do Agro
                            Mercado.</span>
                    </div> --}}

                    {{-- <div class="">
                        <div class="col-12 info-form">
                            <p class="p-2">O Agro
                                Mercado usará seus dados para oferecer e dar suporte aos serviços prestados e para e
                                enviar informações relacionadas ao serviço. Podemos usar esses dados conforme explica a
                                nossa Política de Privacidade. Ao clicar em "continuar”você confirma estar ciente da nossa
                                política e dos termos específicos aplicáveis ao Brasil.</p>
                        </div>
                    </div> --}}

                    <div class="row">
                        <div class="col-9 m-auto d-flex justify-content-center">
                            <button type="submit" class="acess-button register">Continuar</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-9 m-auto d-flex justify-content-center">
                            {{-- <a href="{{ route('password.email') }}" class="btn btn-block btn-primary">
                                <i class="fa fa-lock mr-2"></i> Esqueci minha senha
                            </a> --}}
                            <a href="{{ route('login') }}" class="btn btn-block have-account acess-button">
                                <i class="fa fa-user-plus mr-2"></i> Já tenho conta.
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer class="section-container d-flex flex-column align-items-center footer-register">
        <p>
            O Agro Mercado faz parte de uma rede de comunicação externa ao mundo agro.
            Aqui, consideramos a importância de uma comunicação confiável e próxima.
            Nossa programação é dedicada a trazer conhecimento e insights de forma leve e interessante,
            com o propósito de enriquecer seu dia a dia e agregar valor ao seu trabalho.
        </p>
        <div
            class="d-flex align-items-center justify-content-center w-100 position-relative container-media flex-column flex-sm-row">
            <div class="social-media d-flex justify-content-center">
                <div class="container-social-media">
                    <a href="#"><img src="{{ asset('Auth-Panel/dist/img/instagram.svg') }}" alt=""></a>
                </div>
                <div class="container-social-media">
                    <a href="#"><img src="{{ asset('Auth-Panel/dist/img/youtube.svg') }}" alt=""></a>
                </div>
                <div class="container-social-media">
                    <a href="#"><img src="{{ asset('Auth-Panel/dist/img/facebook.svg') }}" alt=""></a>
                </div>
            </div>
            <img class="logo-footer" src="{{ asset('Auth-Panel/dist/img/logo-white.svg') }}" alt="">
        </div>
        <p class="copyright-footer">Copyright © 2024. Todos os direitos reservados.</p>
    </footer>

    <div class="modal fade" id="modalPlanos" tabindex="-1" aria-labelledby="modalLabelPlanos" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabelPlanos">Planos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   {{-- <section id="planos" class="sixth-section d-flex flex-column align-items-center">
                        <h3 class="text-center">Escolha o plano que mais combina com você!</h3>
                        <p class="subtitle-plans text-center">Estamos desenvolvendo uma <span class="sub">comunicação
                                clara</span>
                            e próxima de você!</p>

                        <div class="d-flex flex-column flex-lg-row align-items-center container-plans position-relative">
                            @foreach ($plans as $plan)--}}{{--todo: preciso alerar aqui também para exibir as tabs--}}{{--
                                <a href="{{ route('register', ['planId' => $plan->id]) }}">
                                    <div
                                        class="plan d-flex flex-column align-items-center {{ $plan->is_best_seller ? 'best-seller' : '' }}">
                                        @if ($plan->is_best_seller)
                                            <div class="box-best-seller position-absolute">
                                                <span>Mais vendido</span>
                                            </div>
                                        @endif

                                        <div class="important-info-plan d-flex flex-column align-items-center">
                                            <span class="title-plan">{{ $plan->name }}</span>
                                            <span class="value-plan">R$ <span
                                                    class="value">{{ number_format($plan->value, 2, ',', '.') }}</span></span>
                                            <span
                                                style="color: black;">{{ $plan->free_for_days > 0 ? $plan->description : 'Renovação Automática' }}</span>
                                        </div>

                                        <div class="about-plan d-flex flex-column align-items-center">
                                            @foreach ($plan->benefits as $benefit)
                                                <div class="about-plan-item d-flex">
                                                    <img src="{{ asset('Auth-Panel/dist/img/plans-icon.svg') }}"
                                                        alt="">
                                                    <span style="color: black;">{{ $benefit->description }}</span>
                                                </div>
                                            @endforeach
                                        </div>

                                        <button type="button" class="btn start-now-button">
                                            Começar agora
                                        </button>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <p class="last-info-plans text-center my-5">Curta nossas <strong>séries</strong>,
                            <strong>filmes</strong> e
                            </strong>conteúdos exclusivos</strong> feitos para você!
                        </p>
                    </section>--}}
                    @include('site.partials.plan-section')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascriptLocal')
    <script>
        $(function() {
            initSelects2();
            initMasks();
        });

        function initSelects2() {
            $('#plan_id').select2({
                theme: "bootstrap4",
                allowClear: true,
            });
        }

        function initMasks() {
            $('#document').mask('000.000.000-00');
            $('#mobile').mask('(00) 00000-0000');
        }
    </script>
@endsection
