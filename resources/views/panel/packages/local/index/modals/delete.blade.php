<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Tem certeza que deseja deletar?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form action="{{ route('panel.packages.destroy', $package->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary btn-submit">Deletar</button>
        </div>
    </form>
</div>
