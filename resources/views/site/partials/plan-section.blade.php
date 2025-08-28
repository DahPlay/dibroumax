<section id="planos" class="planos section">
    <div class="container section-title pb-3" data-aos="fade-up">
        <h2>{{ config('custom.title_plan') }}</h2>
        <p>{{ config('custom.text_plan_1') }}</p>
    </div>

    {{-- Campo de busca e filtro --}}
    <div class="container mb-4" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <input type="text" id="planSearch" class="form-control mb-3"
                    placeholder="Buscar plano por nome, descrição ou benefício...">

                @if (config('custom.telemedicina') == "SIM")
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="planType" id="filterAll" value="all" checked>
                            <label class="form-check-label" for="filterAll">Todos</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="planType" id="filterStreaming"
                                value="streaming">
                            <label class="form-check-label" for="filterStreaming">Streaming</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="planType" id="filterTelemedicina"
                                value="telemedicina">
                            <label class="form-check-label" for="filterTelemedicina">Telemedicina</label>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center">
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                @foreach($cycles as $cycleKey => $cycleName)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $cycleKey === $activeCycle ? 'active' : '' }}"
                            id="pills-{{$cycleKey}}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{$cycleKey}}"
                            type="button" role="tab" aria-controls="pills-{{$cycleKey}}"
                            aria-selected="{{ $cycleKey === $activeCycle ? 'true' : 'false' }}">
                            {{ $cycleName }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content" id="pills-tabContent">
                @foreach($cycles as $cycleKey => $cycleName)
                    <div class="tab-pane fade {{ $cycleKey === $activeCycle ? 'show active' : '' }}"
                        id="pills-{{$cycleKey}}" role="tabpanel" aria-labelledby="pills-{{$cycleKey}}-tab">

                        <div class="row align-items-center">
                            @if(isset($plansByCycle[$cycleKey]))
                                @foreach(collect($plansByCycle[$cycleKey])->sortBy('priority') as $plan)
                                    <div class="col-lg-4 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="200">
                                        <div class="plano-card {{ $plan->is_best_seller ? 'plano-recomendado' : '' }}"
                                            data-name="{{ strtolower($plan->name) }}"
                                            data-description="{{ strtolower($plan->description ?? '') }}"
                                            data-benefits="{{ strtolower(collect($plan->benefits)->pluck('description')->implode(' ')) }}">

                                            @if ($plan->is_best_seller)
                                                <div class="label-recomendado">Recomendado</div>
                                            @endif

                                            <div class="plano-header">
                                                <p>{{ $plan->name }}</p>
                                            </div>

                                            <div class="plano-pricing">
                                                <div class="price">
                                                    <span class="currency">R$</span>

                                                    @if (strtoupper($cycleKey) != 'YEARLY')
                                                        <span class="amount">{{ number_format($plan->value, 2, ',', '.') }}</span>
                                                        <span class="period">Mês</span>
                                                    @else
                                                       <div class="price" style="display: flex; flex-direction: column; align-items: center;">
                                                            <div style="display: flex; align-items: baseline;">
                                                                <span class="currency">R$</span>
                                                                <span class="amount">{{ number_format($plan->value / 12, 2, ',', '.') }}</span>
                                                                <span class="period">Mês</span>
                                                            </div>  
                                                            <div class="annual-info">
                                                                R$ {{ number_format($plan->value, 2, ',', '.') }} Pagamento Anual
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="plano-features">
                                                <p class="descricao">{{ $plan->description }}</p>
                                                <ul>
                                                    @foreach ($plan->benefits as $benefit)
                                                        <li>
                                                            <img src="{{ asset('assets/img/icones/Arrow-1.svg') }}" alt="">
                                                            {{ $benefit->description }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="plano-footer">
                                                <span class="free-days">
                                                    {{ $plan->free_for_days > 0 ? $plan->free_for_days . ' dias grátis' : 'Renovação Automática' }}
                                                </span>
                                                <a href="{{ route('register', ['planId' => $plan->id]) }}" class="btn-plano">
                                                    Quero assinar agora!
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <p class="text-center">Nenhum plano disponível para este ciclo.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container mt-4" data-aos="fade-up">
        <p class="text-center">{{ config('custom.text_plan_2') }}</p>
    </div>
</section>

{{-- Script para busca e filtro --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('planSearch');
        const radios = document.querySelectorAll('input[name="planType"]');

        function filterPlans() {
            const query = searchInput.value.toLowerCase().trim();
            const selectedFilter = document.querySelector('input[name="planType"]:checked')?.value || 'all';
            const activeTab = document.querySelector('.tab-pane.active');
            if (!activeTab) return;

            const planCards = activeTab.querySelectorAll('.plano-card');

            planCards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const description = card.getAttribute('data-description') || '';
                const benefits = card.getAttribute('data-benefits') || '';
                const parentCol = card.closest('.col-lg-4, .col-md-6');

                let matchesSearch = !query || name.includes(query) || description.includes(query) || benefits.includes(query);
                let matchesFilter = selectedFilter === 'all' ||
                    (selectedFilter === 'streaming' && !description.includes('telemedicina')) ||
                    (selectedFilter === 'telemedicina' && description.includes('telemedicina'));

                if (matchesSearch && matchesFilter) {
                    parentCol?.classList.remove('d-none');
                } else {
                    parentCol?.classList.add('d-none');
                }
            });
        }

        searchInput.addEventListener('input', filterPlans);
        radios.forEach(r => r.addEventListener('change', filterPlans));

        // Aplicar filtro inicialmente
        filterPlans();
    });
</script>

<style>
    .plano-card {
        background: #000000ff;
        border-radius: 25px;
        padding: 30px 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        position: relative;
        transition: transform 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .plano-card:hover {
        transform: translateY(-5px);
    }

    .plano-recomendado {
        border: 3px solid
            {{ config('custom.mais_vendido') }}
        ;
    }

    .label-recomendado {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-10%);
        background:
            {{ config('custom.mais_vendido') }}
        ;
        color:
            {{ config('custom.text_mais_vendido') }}
        ;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 16px !important;
        justify-content: center !important;

    }

    .plano-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .plano-header p {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin: 0;
    }

    .plano-pricing {
        text-align: center;
        margin-bottom: 20px;
    }

    .price {
        display: flex;
        align-items: baseline;
        justify-content: center;
        gap: 5px;
    }

    .currency {
        font-size: 20px;
        font-weight: bold;
        color: #333;
    }

    .amount {
        font-size: 40px;
        font-weight: bold;
        color: #333;
    }

    .period {
        font-size: 16px;
        color: #666;
    }

    .annual-info {
        font-size: 18px;
        color: #666;
        margin-top: 5px;
        display: block;
    }

    .plano-features {
        flex-grow: 1;
        margin-bottom: 20px;
    }

    .descricao {
        color: #666;
        text-align: center;
        margin-bottom: 15px;
    }

    .plano-features ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .plano-features li {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        color: #333;
    }

    .plano-features li img {
        margin-right: 10px;
        width: 16px;
        height: 16px;
    }

    .plano-footer {
        text-align: center;
    }

    .free-days {
        display: block;
        color: #666;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .btn-plano {
        display: inline-block;
        background:
            {{ config('custom.mais_vendido') }}
        ;
        color:
            {{ config('custom.text_mais_vendido') }}
        ;
        padding: 12px 30px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .btn-plano:hover {
        background:
            {{ config('custom.mais_vendido') }}
        ;
        /* Você pode adicionar uma cor mais escura para hover */
        opacity: 0.9;
        color:
            {{ config('custom.text_mais_vendido') }}
        ;
    }

    /* Ajustes para responsividade */
    @media (max-width: 768px) {
        .plano-card {
            margin-bottom: 30px;
        }

        .amount {
            font-size: 32px;
        }
    }
</style>