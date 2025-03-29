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
                <div
                    class="about-plan-item d-flex justify-content-start col-12">
                    <img src="{{ asset('Auth-Panel/dist/img/plans-icon.svg') }}" alt="">
                    <span style="color: black;">{{ $benefit->description }}</span>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn start-now-button">
            Começar agora
        </button>
    </div>
</a>
