<section id="planos" class="sixth-section d-flex flex-column align-items-center">
    <h3 class="subtitle-plans text-center" style="color: {{ config('custom.text_home') }};">
        {{ config('custom.title_plan') }}
    </h3>
    <p class="subtitle-plans text-center" style="color: {{ config('custom.text_home') }};">
        {{ config('custom.text_plan_1') }}
    </p>

    <div class="container container-plans">
        <ul class="nav-tabs list-unstyled d-flex justify-content-center mx-auto" id="myTab" role="tablist">
            @foreach($cycles as $cycleKey => $cycleName)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $cycleKey === $activeCycle ? 'active' : '' }}" id="{{$cycleKey . '-tab'}}"
                        data-bs-toggle="tab" data-bs-target="{{'#' . $cycleKey}}" type="button" role="tab"
                        aria-controls="{{$cycleKey}}" aria-selected="{{ $cycleKey === $activeCycle ? 'true' : 'false' }}">
                        {{ $cycleName }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content mt-1 pt-1" id="myTabContent">
            @foreach($cycles as $cycleKey => $cycleName)
                <div class="tab-pane fade {{ $cycleKey === "$activeCycle" ? 'show active' : '' }}" id="{{ $cycleKey }}"
                    role="tabpanel" aria-labelledby="{{ $cycleKey . '-tab' }}">

                    @if(isset($plansByCycle[$cycleKey]))
                        <div class="container-plan-wrapper pt-4 row justify-content-center">
                            @foreach(collect($plansByCycle[$cycleKey])->sortBy('priority') as $plan)
                                <div class="col-12 col-md-6 col-lg-4 mb-4 d-flex">
                                    <div class="plan d-flex flex-column justify-content-between align-items-center w-100 h-100 {{ $plan->is_best_seller ? 'best-seller' : '' }}"
                                        style="
                                            padding: 60px 20px 20px;
                                            border-radius: 8px;
                                            {{ $plan->is_best_seller ? 'border: 4px solid ' . config('custom.mais_vendido') . ';' : 'border: none;' }}
                                            position: relative;
                                        ">

                                        @if ($plan->is_best_seller)
                                            <div class="box-best-seller position-absolute"
                                                style="
                                                    top: 10px;
                                                    left: 50%;
                                                    transform: translateX(-50%);
                                                    padding: 4px 10px;
                                                    background-color: {{ config('custom.mais_vendido') }};
                                                    color: {{ config('custom.text_mais_vendido') }};
                                                    font-weight: bold;
                                                    border-radius: 4px;
                                                    font-size: 13px;
                                                    margin-top:-25px; 
                                                ">
                                                Mais vendido
                                            </div>
                                        @endif

                                        <div class="important-info-plan d-flex flex-column align-items-center">
                                            <span class="title-plan"
                                                style="font-size: 17px; color: {{ config('custom.mais_vendido') }};">
                                                {{ $plan->name }}
                                            </span>
                                            <span class="value-plan" style="color: {{ config('custom.mais_vendido') }};">R$
                                                @if ($cycleName != "ANUAL")
                                                    <span class="value" style="font-size: 45px;">
                                                        {{ number_format($plan->value, 2, ',', '.') }}
                                                    </span>
                                                @else
                                                    <span class="value" style="font-size: 45px;">
                                                        {{ number_format($plan->value / 12, 2, ',', '.') }}
                                                    </span>
                                                    <span class="value" style="font-size: 20px;">/mês</span>
                                                    <br>
                                                    <div style="text-align: center; margin-top: -24px;">
                                                        <span class="value" style="font-size: 12px; font-weight: normal;">
                                                            R$ {{ number_format($plan->value, 2, ',', '.') }} Pagamento Anual
                                                        </span>
                                                    </div>
                                                @endif
                                            </span>
                                            <span class="text-dark">
                                                {{ $plan->free_for_days > 0 ? $plan->free_for_days . ' dias grátis' : 'Renovação Automática' }}
                                            </span>
                                            <span class="text-dark">
                                                {{ $plan->description }}
                                            </span>
                                        </div>

                                        <div class="about-plan d-flex flex-column align-items-start w-100 my-3">
                                            @foreach ($plan->benefits as $benefit)
                                                <div class="about-plan-item d-flex align-items-start mb-1">
                                                    <img src="{{ asset('Auth-Panel/dist/img/plans-icon.svg') }}" alt="" class="me-2">
                                                    <span class="text-dark">{{ $benefit->description }}</span>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="w-100 d-flex justify-content-center mt-auto">
                                            <a href="{{ route('register', ['planId' => $plan->id]) }}" class="w-100">
                                                <button type="button" class="btn start-now-button w-100"
                                                    style="background-color: {{ config('custom.mais_vendido') }};">
                                                    Começar agora
                                                </button>
                                            </a>
                                        </div>
                                    </div>
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

    <p class="last-info-plans text-center" style="color: {{ config('custom.text_home') }};">
        {{ config('custom.text_plan_2') }}
    </p>
</section>
