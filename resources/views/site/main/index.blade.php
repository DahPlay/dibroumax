<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{config('custom.project_name')}}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ config('custom.favicon') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
        <img src="{{ asset('assets/img/logo-branco.svg') }}" alt="{{config('custom.project_name')}}">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#plataforma">A Plataforma</a></li>
          <li><a href="#planos">Planos</a></li>
          <li><a href="#catalogo">Catálogo</a></li>
          <li><a href="#provedores">Provedores</a></li>
          <li><a href="#faq">FAQ</a></li>

          <li class="mobile mt-5"><a class="btn-login" href="{{ route('login') }}"><img src="{{ asset('assets/img/icones/Profile.svg') }}" alt=""> Acessar</a></li>
          <li class="mobile"><a class="btn-cadastro" href="{{ route('register') }}">Cadastre-se</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="desktop">          
        <a class="btn-login" href="{{ route('login') }}"><img src="{{ asset('assets/img/icones/Profile.svg') }}" alt=""> Acessar</a>
        <a class="btn-cadastro" href="{{ route('register') }}">Cadastre-se</a>
      </div>

    </div>
  </header>

  <main class="main">

    <!-- BANNER PRINCIPAL -->
    <section id="hero" class="hero section">
      <div class="container">
        <div class="row">
          <div class="col-lg-7 content-col" data-aos="fade-up">
            <div class="content">
              <div class="main-heading">
                <h1>A casa do esporte e do entretenimento!</h1>
              </div>

              <div class="description">
                <p>Assista aos maiores jogos, eventos esportivos, séries em +110 canais num só lugar, sem cabos, sem antenas e sem complicação.</p>
              </div>

              <div class="cta-button">
                <a href="#planos" class="btn">Quero assinar agora</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- VÍDEO -->
    <section id="plataforma" class="video section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Sua TV por assinatura em qualquer lugar</h2>
        <p>Leve a {{config('custom.project_name')}} no bolso, na TV da sala ou no tablet onde estiver. Tudo em qualidade HD e sem pagar nada a mais por isso</p>
      </div>

      <div class="container">
        <div class="row align-items-center">
          <div class="col" data-aos="fade-right" data-aos-delay="200">
            <iframe width="100%" height="515" src="https://www.youtube.com/embed/keE3dUv5E-M?si=0LoIDk8ZQM49x_lU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </section>

    <!-- CAMPEONATOS -->
    <section id="catalogo" class="catalogo section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center">
          <div class="col-lg-6 col-md-12 section-title">
            <h2 class="text-start">Os maiores campeonatos e eventos esportivos estão aqui.</h2>
            <p class="text-start">Na {{config('custom.project_name')}} você acompanha ao vivo os torneios mais emocionantes do mundo.</p>

            <div class="cta-button">
              <a href="#planos" class="btn">Quero assinar agora</a>
            </div>
          </div>

          <div class="col-lg-6 col-md-12">
            <div class="row">
              <div class="col-4" data-aos="fade-up" data-aos-delay="100">
                <div class="campeonato-card">
                  <img src="{{ asset('assets/img/campeonatos/ChampionsLeague.svg') }}" alt="Champions League">
                </div>
              </div>

              <div class="col-4" data-aos="fade-up" data-aos-delay="100">
                <div class="campeonato-card">
                  <img src="{{ asset('assets/img/campeonatos/PremierLeague.svg') }}" alt="Premier League">
                </div>
              </div>

              <div class="col-4" data-aos="fade-up" data-aos-delay="100">
                <div class="campeonato-card">
                  <img src="{{ asset('assets/img/campeonatos/LaLiga.svg') }}" alt="La Liga">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-4" data-aos="fade-up" data-aos-delay="100">
                <div class="campeonato-card">
                  <img src="{{ asset('assets/img/campeonatos/LaLigaPortugal.svg') }}" alt="Liga Portugal">
                </div>
              </div>

              <div class="col-4" data-aos="fade-up" data-aos-delay="100">
                <div class="campeonato-card">
                  <img src="{{ asset('assets/img/campeonatos/LaLigaPortugal.svg') }}" alt="Liga Portugal">
                </div>
              </div>
              
              <div class="col-4" data-aos="fade-up" data-aos-delay="100">
                <div class="campeonato-card">
                  <img src="{{ asset('assets/img/campeonatos/Brasileirao.svg') }}" alt="Brasileirão">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-4" data-aos="fade-up" data-aos-delay="100">
                <div class="campeonato-card">
                  <img src="{{ asset('assets/img/campeonatos/Bundesliga.svg') }}" alt="Bundesliga">
                </div>
              </div>

              <div class="col-4" data-aos="fade-up" data-aos-delay="100">
                <div class="campeonato-card">
                  <img src="{{ asset('assets/img/campeonatos/NBA.svg') }}" alt="NBA">
                </div>
              </div>
              
              <div class="col-4" data-aos="fade-up" data-aos-delay="100">
                <div class="campeonato-card">
                  <img src="{{ asset('assets/img/campeonatos/Formula1.svg') }}" alt="Fórmula 1">
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </section>

    <!-- TOP 5 -->
    <!-- <section class="section">
      <div class="container section-title" data-aos="fade-up">
        <h2>O que o mundo está vendo agora!</h2>
        <p>Confira os conteúdos mais assistidos da semana e descubra por que a {{config('custom.project_name')}}<br>já conquistou milhares de apaixonados por esporte e entretenimento</p>
      </div>

      <div class="container">
        <div class="row align-items-center">
          <div class="col" data-aos="fade-right" data-aos-delay="200">
              <img src="{{ asset('assets/img/campeonatos/ChampionsLeague.svg') }}" alt="Conteúdo 1">
          </div>

          <div class="col" data-aos="fade-right" data-aos-delay="300">
              <img src="{{ asset('assets/img/campeonatos/ChampionsLeague.svg') }}" alt="Conteúdo 2">
          </div>

          <div class="col" data-aos="fade-right" data-aos-delay="400">
              <img src="{{ asset('assets/img/campeonatos/ChampionsLeague.svg') }}" alt="Conteúdo 3">
          </div>

          <div class="col" data-aos="fade-right" data-aos-delay="500">
              <img src="{{ asset('assets/img/campeonatos/ChampionsLeague.svg') }}" alt="Conteúdo 4">
          </div>

          <div class="col" data-aos="fade-right" data-aos-delay="600">
              <img src="{{ asset('assets/img/campeonatos/ChampionsLeague.svg') }}" alt="Conteúdo 5">
          </div>
        </div>
      </div>
    </section> -->

    <!-- PROVEDORES -->
    <section id="provedores" class="provedores section mt-5">
      <div class="container section-title" data-aos="fade-up">
        <h2>Mais de 110 canais em um só lugar</h2>
        <p>{{config('custom.project_name')}} é a sua TV por assinatura online, com mais de 110 canais ao vivo e<br>milhares de horas On Demand para você assistir quando e onde quiser</p>
      </div>

      <div class="container">
        <div class="row">
          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="canais-card">
              <img src="{{ asset('assets/img/canais/SBT.webp') }}" alt="SBT">
            </div>
          </div>

          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="canais-card">
              <img src="{{ asset('assets/img/canais/band-sports.webp') }}" alt="Band Sports">
            </div>
          </div>

          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="canais-card">
              <img src="{{ asset('assets/img/canais/band.webp') }}" alt="Band">
            </div>
          </div>

          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="canais-card">
              <img src="{{ asset('assets/img/canais/bandnews.webp') }}" alt="BandNews">
            </div>
          </div>

          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="canais-card">
              <img src="{{ asset('assets/img/canais/record.webp') }}" alt="Record">
            </div>
          </div>

          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="canais-card">
              <img src="{{ asset('assets/img/canais/xsports.png') }}" alt="XSports">
            </div>
          </div>

          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="canais-card">
              <img src="{{ asset('assets/img/canais/cnn.png') }}" alt="CNN">
            </div>
          </div>

          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="canais-card">
              <img src="{{ asset('assets/img/canais/tnt.webp') }}" alt="TNT">
            </div>
          </div>

          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="canais-card">
              <img src="{{ asset('assets/img/canais/gazeta.webp') }}" alt="Gazeta">
            </div>
          </div>

          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="canais-card">
              <img src="{{ asset('assets/img/canais/redetv.webp') }}" alt="RedeTV">
            </div>
          </div>

          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="canais-card">
              <img src="{{ asset('assets/img/canais/turfe.webp') }}" alt="Turfe">
            </div>
          </div>

          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="canais-card">
              <img src="{{ asset('assets/img/canais/jockey.webp') }}" alt="Jockey">
            </div>
          </div>

          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="canais-card">
              <img src="{{ asset('assets/img/canais/cancaonova.webp') }}" alt="Canção Nova">
            </div>
          </div>

          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="canais-card">
              <img src="{{ asset('assets/img/canais/unique.webp') }}" alt="Unique">
            </div>
          </div>

          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="canais-card">
              <img src="{{ asset('assets/img/canais/discover.png') }}" alt="Discovery">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <h3>Tudo isso e muito +</h3>
          </div>
        </div>
      </div>
    </section>

    <!-- CONTEÚDOS -->
    <section class="section conteudos">
      <div class="container">
        <div class="row align-items-center">
          <div class="col" data-aos="fade-right" data-aos-delay="1000">
            <img src="{{ asset('assets/img/icones/Live.svg') }}" alt="Ao Vivo">
            <h4>+110 canais<br>ao vivo</h4>
            <p>De esportes, filmes, séries e notícias</p>
          </div>

          <div class="col" data-aos="fade-right" data-aos-delay="800">
            <img src="{{ asset('assets/img/icones/Soccer.svg') }}" alt="Futebol">
            <h4>Grandes ligas<br>de futebol</h4>
            <p>Champions League, Premier League, Serie A TIM,  e mais.</p>
          </div>

          <div class="col" data-aos="fade-right" data-aos-delay="600">
            <img src="{{ asset('assets/img/icones/F1.svg') }}" alt="F1">
            <h4>Do Basquete à<br>velocidade nas pistas</h4>
            <p>NBA, NBB Caixa, Fórmula 1 e NASCAR</p>
          </div>

          <div class="col" data-aos="fade-right" data-aos-delay="400">
            <img src="{{ asset('assets/img/icones/Movie.svg') }}" alt="Filmes">
            <h4>Conteúdo<br>On Demand</h4>
            <p>Filmes e séries pra toda família</p>
          </div>

          <div class="col" data-aos="fade-right" data-aos-delay="200">
            <img src="{{ asset('assets/img/icones/Diamond.svg') }}" alt="Diamante">
            <h4>TV por assinatura<br>sem complicação</h4>
            <p>Mais acessível, moderno e sem fidelidade</p>
          </div>
        </div>
      </div>
    </section>

    <!-- PLANOS -->
    @include('site.partials.plan-section')

    <!-- FAQ -->
    <section class="faq section" id="faq">
      <div class="container section-title" data-aos="fade-up">
        <h2>Perguntas Frequentes</h2>
      </div>

      <div class="container">
        <div class="row">
          <div class="col" data-aos="fade-up" data-aos-delay="300">
            <div class="faq-container">

              <div class="faq-item faq-active">
                <h3>O que é a {{config('custom.project_name')}}?</h3>
                <div class="faq-content">
                  <p>{{config('custom.project_name')}} é uma plataforma de TV por assinatura via internet. Com ela, você tem acesso a mais de <b>110 canais ao vivo</b>, filmes, séries e grandes campeonatos esportivos em qualidade HD, sem precisar de cabos ou decodificadores. Basta have conexão com a internet e um dispositivo compatível, como Smart TV, celular, computador ou tablet.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Em quais dispositivos posso assistir à {{config('custom.project_name')}}?</h3>
                <div class="faq-content">
                  <p>A {{config('custom.project_name')}} é compatível com uma ampla variedade de dispositivos:</p>
                  <ul>
                    <li>Smart TVs (LG, Samsung, Android TV)</li>
                    <li>Dispositivos de streaming (Apple TV, Roku, Chromecast, Fire TV Stick, Android TV Box)</li>
                    <li>Celulares e tablets (iOS e Android)</li>
                    <li>Computadores e notebooks via navegador</li>
                  </ul>                  
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>A {{config('custom.project_name')}} é legal e segura?</h3>
                <div class="faq-content">
                  <p>Sim. A {{config('custom.project_name')}} é 100% legal e segura. Todos os canais e conteúdos são licenciados oficialmente, diferente de IPTV piratas que distribuem conteúdo ilegal. Além disso, todas as transações são criptografadas e protegidas, garantindo a segurança dos seus dados.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Posso cancelar minha assinatura da {{config('custom.project_name')}} quando quiser?</h3>
                <div class="faq-content">
                  <p>Sim. Você pode cancelar sua assinatura a qualquer momento diretamente na sua conta, sem burocracia e sem fidelidade.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Quantos dispositivos posso usar com minha conta {{config('custom.project_name')}}?</h3>
                <div class="faq-content">
                  <p>Você pode registrar até <b>5 dispositivos</b> diferentes na sua conta. A reprodução simultânea é limitada a <b>3 dispositivos</b>, podendo ser usados em até 2 redes de internet diferentes.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>O que fazer se minha TV não for compatível com a {{config('custom.project_name')}}?</h3>
                <div class="faq-content">
                  <p>Mesmo que sua TV seja mais antiga, você pode transformar qualquer tela em uma TV com {{config('custom.project_name')}} usando dispositivos como Roku, Apple TV, Android TV Box, Chromecast ou Fire TV Stick. Basta ter internet disponível.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>A {{config('custom.project_name')}} oferece teste grátis?</h3>
                <div class="faq-content">
                  <p>Atualmente não oferecemos teste grátis. Os planos começam a partir de <b>R$29,90 por mês</b>, e você pode cancelar a qualquer momento, sem fidelidade.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Quais campeonatos posso assistir na {{config('custom.project_name')}}?</h3>
                <div class="faq-content">
                  <p>Na {{config('custom.project_name')}} você acompanha ao vivo alguns dos maiores eventos esportivos do mundo, incluindo: <b>Premier League, La Liga, Serie A TIM, Bundesliga, Liga de Portugal, NBA, NBB Caixa, Fórmula 1 e NASCAR,</b> entre outros.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container">
      <div class="row d-flex justify-content-between align-items-stretch">
        <div class="col links align-self-center">
          <a href="#">Termos e Condições</a>
          <a href="#">Política e Privacidade</a>
        </div>
        <div class="col copyright align-self-center">© 2025 - Operado por P&K Telecom / © 2025 - SIMBA • 54.727.915/0001-22</div>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>