<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Tem certeza que deseja deletar?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form>
        @csrf
        @method('DELETE')

        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary btn-submit">Deletar</button>
        </div>
    </form>
</div>

<script>
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
                url: '{{ $routeCrud }}/destroy/' + id,
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
</script>
