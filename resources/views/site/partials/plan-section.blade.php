<section id="planos" class="sixth-section d-flex flex-column align-items-center">
    <h3 class="subtitle-plans text-center">Escolha o plano que mais combina com você!</h3>
    <p class="subtitle-plans text-center">Estamos desenvolvendo uma <span class="sub">comunicação clara</span> e próxima de você!</p>

    <div class="container container-plans">
        <ul class="nav-tabs list-unstyled d-flex justify-content-center mx-auto" id="myTab" role="tablist">
            @foreach($cycles as $cycleKey => $cycleName)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $cycleKey === $activeCycle ? 'active' : '' }}"
                            id="{{$cycleKey.'-tab'}}"
                            data-bs-toggle="tab" data-bs-target="{{'#'.$cycleKey}}"
                            type="button" role="tab"
                            aria-controls="{{$cycleKey}}"
                            aria-selected="{{ $cycleKey === $activeCycle ? 'true' : 'false' }}">
                        {{ $cycleName }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content mt-5 pt-5" id="myTabContent">
            @foreach($cycles as $cycleKey => $cycleName)
                <div class="tab-pane fade {{ $cycleKey === $activeCycle ? 'show active' : '' }}"
                     id="{{$cycleKey}}"
                     role="tabpanel"
                     aria-labelledby="{{$cycleKey.'-tab'}}">

                    @if(isset($plansByCycle[$cycleKey]))
                        <div class="row g-4 justify-content-center">
                            @foreach($plansByCycle[$cycleKey] as $plan)
                                <div class="col-12 col-sm-6 col-lg-4 d-flex container-plan">
                                    <a href="{{ route('register', ['planId' => $plan->id]) }}" class="m-2 w-100">
                                        <div class="plan d-flex flex-column align-items-center h-100 {{ $plan->is_best_seller ? 'best-seller' : '' }}">
                                            @if ($plan->is_best_seller)
                                                <div class="box-best-seller position-absolute">
                                                    <span>Mais vendido</span>
                                                </div>
                                            @endif

                                            <div class="important-info-plan d-flex flex-column align-items-center">
                                                <span class="title-plan">{{ $plan->name }}</span>
                                                <span class="value-plan">R$
                                                    <span class="value">{{ number_format($plan->value, 2, ',', '.') }}</span>
                                                </span>
                                                <span class="text-dark">
                                                    {{ $plan->free_for_days > 0 ? $plan->description : 'Renovação Automática' }}
                                                </span>
                                            </div>

                                            <div class="about-plan d-flex flex-column align-items-center w-100">
                                                @foreach ($plan->benefits as $benefit)
                                                    <div class="about-plan-item d-flex justify-content-start w-100">
                                                        <img src="{{ asset('Auth-Panel/dist/img/plans-icon.svg') }}" alt="">
                                                        <span class="text-dark">{{ $benefit->description }}</span>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <button type="button" class="btn start-now-button">
                                                Começar agora
                                            </button>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">Nenhum plano disponível para este ciclo.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <p class="last-info-plans text-center">Curta nossas <strong>séries</strong>, <strong>filmes</strong> e <strong>conteúdos exclusivos</strong> feitos para você!</p>
</section>
