<div class="modal-body">
    <div class="row d-flex align-items-center">
        <div class="form-group col-12">
            <label for="name" class="col-form-label text-danger">Nome: *</label>
            <div class="input-group">
                <input type="text" id="name" class="form-control" name="name" placeholder="Nome *"
                    value="{{ $access->name ?? old('name') }}" required>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {});
</script>
