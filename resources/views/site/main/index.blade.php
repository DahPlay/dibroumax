<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('app.name')}}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100..900;1,100..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/helvetica-neue-55" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Auth-Panel/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Auth-Panel/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('Auth-Panel/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('Auth-Panel/dist/img/favicon.png') }}"/>
    <link rel="stylesheet" href="{{ asset('Auth-Panel/dist/css/front/front.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
</head>

<body>
<header class="d-flex justify-content-center justify-content-lg-end position-relative"
        style="background-image: url('{{ asset('Auth-Panel/dist/img/background-header.svg') }}'); background-repeat: no-repeat;">

    <div class="align-items-center container-nav d-flex justify-content-between position-absolute">
        <img src="{{ asset('Auth-Panel/dist/img/logo.svg') }}">

        <div class="d-flex flex-column d-lg-none menu" onclick="toggleMenu()">
            <div class="menu-bar"></div>
            <div class="menu-bar"></div>
            <div class="menu-bar"></div>
        </div>

        <nav
            class="justify-content-end justify-content-lg-center ml-0 mr-0 navbar navbar-expand col nav d-none d-lg-flex">
            <ul class="d-lg-flex d-none justify-content-lg-center navbar-nav">
                <li class="px-4"><a href="#planos">Planos</a></li>
                <li class="px-4"><a href="#sobre-a-plataforma">Sobre a plataforma</a></li>
                <li class="px-4"><a href="#catalogo">Catálogo</a></li>
                <li class="px-4"><a href="{{ route('login') }}">Gerenciar</a></li>
                <li class="active px-4"><a href="#planos">Cadastre-se</a></li>
                <li class="active px-4" style="background-color: white;">
                    <a href="https://portal.agroplay.tv.br/login" target="_blank">
                        <img src="{{ asset('Auth-Panel/dist/img/logo-agro-play.png') }}"
                             style="width: 100px; margin: 0px;" alt="">
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <nav class="mobile-menu" id="mobileMenu">
        <ul>
            <li><a href="#planos" onclick="toggleMenu()">Planos</a></li>
            <li><a href="#sobre-a-plataforma" onclick="toggleMenu()">Sobre a plataforma</a></li>
            <li><a href="#catalogo" onclick="toggleMenu()">Catálogo</a></li>
            <li><a href="{{ route('login') }}">Logar</a></li>
            <li><a href="#planos">Cadastre-se</a></li>
            <li class="active px-4" style="background-color: white;">
                <a href="https://portal.agroplay.tv.br/login" target="_blank">
                    <img src="{{ asset('Auth-Panel/dist/img/logo-agro-play.png') }}"
                         style="width: 140px; margin: 0px;" alt="">
                </a>
            </li>
        </ul>
    </nav>

    <div class="div-header d-flex div-header flex-column justify-content-center px-5 px-lg-0">
        <span>Conecte-se ao futuro do Agronegócio</span>

        <p>Agora o conteúdo mais relevante do mercado agro está ao seu alcance, em qualquer lugar! Notícias, eventos
            e muitos mais na nossa plataforma de streaming.</p>

        <a href="#planos">Experimente Grátis por 7 dias</a>
    </div>
</header>


<section id="sobre-a-plataforma" class="d-flex first-section flex-column flex-lg-row section-container text-center">
    <div>
        <h3>Assista quando e onde quiser!</h3>
        <p>Disponível na sua smart TV, celular, tablet ou notebook, sem nenhum custo adicional.</p>
    </div>

    <div class="first-section-video">
        <iframe height="315" src="https://www.youtube.com/embed/sg0QNOFcjys?si=mhKIq-6JdsYqnJDU"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
</section>

<section class="align-items-center d-flex flex-column-reverse flex-lg-row second-section section-container">
    <div class="position-relative d-inline-block">
        <img class="vetor-info" src="{{ asset('Auth-Panel/dist/img/vetor-info.svg') }}" alt="">

        <div class="about-container position-absolute d-flex flex-column">
            <div class="about">
                <img src="{{ asset('Auth-Panel/dist/img/about-icon.svg') }}" alt="">

                <div class="about-item">
                    <span class="about-title">Conteúdo ilimitado</span>
                    <span class="about-subtitle">Assista quando e onde quiser!</span>
                </div>
            </div>
            <div class="about">
                <img src="{{ asset('Auth-Panel/dist/img/about-icon.svg') }}" alt="">

                <div class="about-item">
                    <span class="about-title">2.500 HORAS</span>
                    <span class="about-subtitle">De filme para toda a família</span>
                </div>
            </div>

            <div class="about">
                <img src="{{ asset('Auth-Panel/dist/img/about-icon.svg') }}" alt="">

                <div class="about-item">
                    <span class="about-title">Programação exclusiva</span>
                    <span class="about-subtitle">Últimas tendências e lançamentos!</span>
                </div>
            </div>
        </div>

        <img class="arrow position-absolute" src="{{ asset('Auth-Panel/dist/img/arrow-down.svg') }}"
             alt="">
    </div>
    <div class="">
        <h2 class="font-weight-bold">Explore o universo agro com nosso canal de streaming exclusivo!</h2>

        <p>Além dos melhores filmes e séries, você tem acesso a conteúdos dedicados ao mundo agro: insights,
            tendências e novidades feitas para quem vive e respira esse setor. Assine e mergulhe no que há de
            mais completo para o campo e além!</p>
    </div>
</section>

<section id="catalogo" class="third-section section-container pr-0">
    <h3 class="font-weight-bold">Canais Agro</h3>

    <div class="swiper mySwiper">
        <div class="swiper-wrapper channels-agro">
            <div class="channel-item swiper-slide d-flex justify-content-center align-items-center">
                <span class="channel-number">1</span>
                <img class="channel-photo" src="{{ asset('Auth-Panel/dist/img/agro-1.svg') }}" alt="">
            </div>

            <div class="channel-item swiper-slide d-flex justify-content-center align-items-center">
                <span class="channel-number">2</span>
                <img class="channel-photo" src="{{ asset('Auth-Panel/dist/img/agro-2.svg') }}" alt="">
            </div>

            <div class="channel-item swiper-slide d-flex justify-content-center align-items-center">
                <span class="channel-number">3</span>
                <img class="channel-photo" src="{{ asset('Auth-Panel/dist/img/agro-3.svg') }}" alt="">
            </div>

            <div class="channel-item swiper-slide d-flex justify-content-center align-items-center">
                <span class="channel-number">4</span>
                <img class="channel-photo" src="{{ asset('Auth-Panel/dist/img/agro-4.svg') }}" alt="">
            </div>

            <div class="channel-item swiper-slide d-flex justify-content-center align-items-center">
                <span class="channel-number">5</span>
                <img class="channel-photo" src="{{ asset('Auth-Panel/dist/img/agro-1.svg') }}" alt="">
            </div>
        </div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>

<section class="fourth-section section-container pr-0">
    <h3 class="font-weight-bold">Filmes e séries</h3>

    <div class="swiper moviesSwiper">
        <div class="swiper-wrapper movies-area">
            <div class="swiper-slide d-flex justify-content-center align-items-center">
                <img class="channel-photo" src="{{ asset('Auth-Panel/dist/img/movie-1.svg') }}" alt="">
            </div>

            <div class="swiper-slide d-flex justify-content-center align-items-center">
                <img class="channel-photo" src="{{ asset('Auth-Panel/dist/img/movie-2.svg') }}" alt="">
            </div>

            <div class="swiper-slide d-flex justify-content-center align-items-center">
                <img class="channel-photo" src="{{ asset('Auth-Panel/dist/img/movie-3.svg') }}" alt="">
            </div>

            <div class="swiper-slide d-flex justify-content-center align-items-center">
                <img class="channel-photo" src="{{ asset('Auth-Panel/dist/img/movie-4.svg') }}" alt="">
            </div>

            <div class="swiper-slide d-flex justify-content-center align-items-center">
                <img class="channel-photo" src="{{ asset('Auth-Panel/dist/img/movie-5.svg') }}" alt="">
            </div>
        </div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>

<section class="fifth-section section-container position-relative">
    <div class="container-woman col-6">
        <img src="{{ asset('Auth-Panel/dist/img/woman.svg') }}" alt="">
    </div>

    <div class="container-infos col-6">
        <h3>O melhor conteúdo agro!</h3>
        <p>Salve seus filmes ou séries favoritas e assista mesmo sem internet.</p>
    </div>
</section>

@include('site.partials.plan-section')

<footer class="section-container d-flex flex-column align-items-center">
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
                <a href="#"><img src="{{ asset('Auth-Panel/dist/img/instagram.svg') }}"
                                 alt=""></a>
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

<script src="{{ asset('Auth-Panel/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('Auth-Panel/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('Auth-Panel/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('Auth-Panel/dist/js/demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<!-- Bootstrap CSS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('Auth-Panel/dist/js/front/front.js') }}"></script>
<script>
    $(function () {
        const swiper = new Swiper('.mySwiper', {
            slidesPerView: 4,
            slidesPerGroup: 1,
            loop: false,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            spaceBetween: 10,
            breakpoints: {
                992: {
                    slidesPerView: 4,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 1,
                },
                300: {
                    slidesPerView: 1,
                }
            }
        });

        const moviesSwiper = new Swiper('.moviesSwiper', {
            slidesPerView: 4,
            slidesPerGroup: 1,
            loop: false,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            spaceBetween: 10,
            breakpoints: {
                992: {
                    slidesPerView: 4,
                },
                768: {
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 1,
                },
                300: {
                    slidesPerView: 1,
                }
            }
        });

        $('a[href^="#"]').on('click', function (event) {
            event.preventDefault();

            const target = $(this.getAttribute('href'));

            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
            }
        });
    })
</script>

<!-- inicio Flut -->
<script src='https://sistema.flut.com.br/api/company/showModal?x=92&z=https://portal.agromercado.tv.br/&o='></script>
<!-- fim Flut -->
</body>

</html>
