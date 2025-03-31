<section id="planos" class="sixth-section d-flex flex-column align-items-center">
    <h3 class="text-center">Escolha o plano que mais combina com você!</h3>
    <p class="subtitle-plans text-center">Estamos desenvolvendo uma <span class="sub">comunicação clara</span>
        e próxima de você!</p>

    <div class="d-flex justify-content-center">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
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
                        <div class="d-flex flex-wrap">
                            @foreach($plansByCycle[$cycleKey] as $plan)
                                <div
                                    class="d-flex flex-column flex-lg-row align-items-center container-plans position-relative">
                                    <a href="{{ route('register', ['planId' => $plan->id]) }}" class="m-2 col-12">
                                        <div
                                            class="plan d-flex flex-column align-items-center {{ $plan->is_best_seller ? 'best-seller' : '' }}">
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
                                                <span style="color: black;">
                                        {{ $plan->free_for_days > 0 ? $plan->description : 'Renovação Automática' }}
                                    </span>
                                            </div>

                                            <div class="about-plan d-flex flex-column align-items-center">
                                                @foreach ($plan->benefits as $benefit)
                                                    <div class="about-plan-item d-flex justify-content-start col-12">
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
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>Nenhum plano disponível para este ciclo.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <p class="last-info-plans text-center">Curta nossas <strong>séries</strong>, <strong>filmes</strong> e
        <strong>conteúdos exclusivos</strong> feitos para você!</p>
</section>
