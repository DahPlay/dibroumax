<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Criar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <form action="{{ route('panel.packages.store') }}" method="POST">
        @method('POST')
        @csrf}
        @include("includes.forms.$routeCrud")
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary btn-submit">Criar</button>
        </div>
    </form>
</div>
