<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Visualizar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form id="formShow{{ ucfirst($routeCrud) }}">
        @csrf
        @method('PUT')

        <input type="hidden" id="id" name="id" value="{{ $order->id }}">

        @include("includes.forms.$routeCrud")

        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </form>
</div>
