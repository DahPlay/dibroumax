<div class="modal-content">
    <div class="modal-header">
        <div class="d-flex flex-column justify-content-center align-items-center mx-auto">
            <h3 class="text-center"><strong>Escolha o plano que mais combina com você!</strong></h3>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <section id="planos" class="sixth-section d-flex flex-column align-items-center">
            <div class="container">
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

                <div class="tab-content" id="myTabContent">
                    @foreach($cycles as $cycleKey => $cycleName)
                        <div class="tab-pane fade {{ $cycleKey === $activeCycle ? 'show active' : '' }}"
                             id="{{$cycleKey}}"
                             role="tabpanel"
                             aria-labelledby="{{$cycleKey.'-tab'}}">

                            @if(isset($plansByCycle[$cycleKey]))
                                <div class="row g-4 justify-content-center">
                                    @foreach($plansByCycle[$cycleKey] as $plan)
                                        <div
                                            class="relative col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center align-content-center ml-4 p-4 border rounded bg-light">
                                            <div
                                                class="m-2 w-100">
                                                <div
                                                    class="plan d-flex flex-column align-items-center h-100 {{ $plan->is_best_seller ? 'best-seller' : '' }}">
                                                    @if ($plan->is_best_seller)
                                                        <div class="box-best-seller position-absolute">
                                                            <span>Mais vendido</span>
                                                        </div>
                                                    @endif

                                                    <div
                                                        class="d-flex flex-column align-items-center">
                                                        <span class="badge text-xl">{{ $plan->name }}</span>
                                                        <span class="badge text-lg">R$
                                                    <span
                                                        class="value">{{ number_format($plan->value, 2, ',', '.') }}</span>
                                                </span>
                                                        <span class="badge fs-2">
                                                    {{ $plan->free_for_days > 0 ? $plan->description : 'Renovação Automática' }}
                                                </span>
                                                    </div>

                                                    <div class="mb-3 d-flex flex-column align-items-center w-100">
                                                        @foreach ($plan->benefits as $benefit)
                                                            <div
                                                                class="mb-2 d-flex justify-content-start w-100">
                                                                <img
                                                                    src="{{ asset('Auth-Panel/dist/img/plans-icon.svg') }}"
                                                                    alt="">
                                                                <span
                                                                    class="text-dark">{{ $benefit->description }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <form class="absolute bottom-3"
                                                          action="{{ route('panel.orders.changePlanStore') }}"
                                                          method="post">
                                                        @csrf
                                                        @method('POST')

                                                        <input type="hidden" name="planId" value="{{ $plan->id }}">
                                                        <input type="hidden" name="orderId" value="{{ $order->id }}">

                                                        <div class="modal-footer justify-content-between">
                                                            <button type="submit"
                                                                    class="btn"
                                                                    style="border: none; background-color: #5A701E; color: white; font-weight: 600; padding: 8px 48px; border-radius: 8px;">
                                                                Começar agora
                                                            </button>
                                                        </div>
                                                    </form>


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

            <p class="mt-5 text-center">Curta nossas <strong>séries</strong>, <strong>filmes</strong> e
                <strong>conteúdos exclusivos</strong> feitos para você!</p>
        </section>

    </div>
    <!-- Bootstrap CSS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</div>

<style scoped>
    .container-plans {
        font-family: "Inter";
        /*gap: 32px;*/
    }
</style>

{{--<script>
    $("form").on('submit', function(e) {
        e.preventDefault();

        var id = '{{ $order->id }}';

        var dados = {
            'id': id,
        }

        $(".btn-submit").attr('disabled', true).text('Enviando...');

        $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: 'DELETE',
                url: '{{ $routeCrud }}/canceling/' + id,
                data: dados,
            })
            .done(function(data) {

                if (data.status == 400) {
                    Object.keys(data.errors).forEach((item) => {
                        $("#" + item).addClass('is-invalid');
                        toastMessage('fa fa-exclamation', 'bg-danger', 'Ops, houve um erro!', data
                            .errors[item]);
                    });

                    $(".btn-submit").removeAttr('disabled', true).text('Deletar');
                } else if (data.status == 200) {
                    $('.modal').modal('hide');

                    $('#table').DataTable().draw(true);

                    $("#btn-marcar-todos").prop('checked', false);

                    toastMessage('fa fa-check', 'bg-success', 'Sucesso!', data.message);
                } else {
                    toastMessage('fa fa-exclamation', 'bg-warning', 'Atenção!',
                        'Tente novamente ou entre em contato com o administrador do sistema !');
                }

            })
            .fail(function() {
                $(".btn-submit").removeAttr('disabled', true).text('Deletar');
            })
            .always(function() {
                $(".btn-submit").removeAttr('disabled', true).text('Deletar');
            });
    });
</script>--}}
