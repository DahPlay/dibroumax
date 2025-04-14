<div class="modal-body">
    <div class="row">
        <div class="form-group col-12 col-md-6">
            <label for="name" class="col-form-label text-danger">Nome: *</label>
            <div class="input-group">
                <input type="text" id="name" class="form-control" name="name" placeholder="Nome *"
                    value="{{ $package->name ?? old('name') }}" required>
            </div>
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="cod" class="col-form-label text-danger">Código: *</label>
            <div class="input-group">
                <input type="text" id="cod" class="form-control" name="cod" placeholder="Código *"
                       value="{{ $package->cod ?? old('cod') }}" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12 col-md-6">
                <label for="vendor_id" class="col-form-label text-danger">Vendor ID:</label>
                <div class="input-group">
                    <input type="text" id="vendor_id" class="form-control" name="vendor_id" placeholder="vendor_id"
                           value="{{ $package->vendor_id ?? old('vendor_id') }}">
                </div>
            </div>
            <div class="form-group col-12 col-md-3 p-0">
                <div class="custom-control custom-switch custom-switch-on-primary d-flex align-items-center"
                     style="width: 250px;">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" class="custom-control-input overdue" name="is_active" id="is_active"
                            {{ $package->is_active ? 'checked' : '' }}>
                    <label class="custom-control-label font-weight-normal ml-2" for="is_active">Ativo</label>
                </div>
            </div>
            <div class="form-group col-12 col-md-3 p-0">
                <div class="custom-control custom-switch custom-switch-on-primary d-flex align-items-center"
                     style="width: 250px;">
                    <input type="hidden" name="is_suspension" value="0">
                    <input type="checkbox" class="custom-control-input overdue" name="is_suspension" id="is_suspension"
                            {{ $package->is_suspension ? 'checked' : '' }}>
                    <label class="custom-control-label font-weight-normal ml-2" for="is_suspension">Pacote suspensão</label>
                </div>
            </div>
        </div>
    </div>
</div>