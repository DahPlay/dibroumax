<div class="modal-body">
    <div class="row d-flex align-items-center">
        <div class="form-group col-12 col-md-6">
            <label for="photo" class="col-form-label">Foto:</label>
            <div class="input-group">
                <input type="file" id="photo" name="photo">
            </div>
        </div>

        @if ($user->photo)
            <div class="col-6">
                <div class="card">
                    <div class="card-body m-auto">
                        <img width="100" data-url="/user/removeImage/" data-id="{{ $user->id }}"
                            data-token={{ csrf_token() }} src="{{ asset('storage/' . $user->photo) }}" alt="">
                        @if ($user->photo != 'avatars/default.png')
                            <button type="button" class="btn-remove" title="Remover">x</button>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="col-6">
                <div class="card">
                    <div class="card-body m-auto">
                        <img width="100" src="{{ asset('Auth-Panel/dist/img/not-image.png') }}" alt="">
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="form-group col-6">
            <label for="name" class="col-form-label text-danger">Nome: *</label>
            <div class="input-group">
                <input type="text" id="name" class="form-control" name="name" placeholder="Nome *"
                    value="{{ $user->name ?? old('name') }}" required>
            </div>
        </div>

        <div class="form-group col-6">
            <label for="access_id" class="col-form-label text-danger">Perfil: *</label>
            <select id="access_id" class="form-control" name="access_id" required>
                @foreach ($accesses as $access)
                    <option value='{{ $access->id }}' {{ $user->access_id == $access->id ? 'selected' : '' }}>
                        {{ $access->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-12 col-md-4">
            <label for="email" class="col-form-label text-danger">E-mail: *</label>
            <div class="input-group">
                <input type="email" id="email" class="form-control" name="email" placeholder="E-mail *"
                    value="{{ $user->email ?? old('email') }}" required>
            </div>
        </div>

        <div class="form-group col-12 col-md-4">
            <label for="name" class="col-form-label">Senha:</label>
            <div class="input-group">
                <input type="password" id="password" class="form-control" name="password" placeholder="Senha *"
                    autocomplete="off">
            </div>
        </div>

        <div class="form-group col-12 col-md-4">
            <label for="name" class="col-form-label">Confirmar senha:</label>
            <div class="input-group">
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                    placeholder="Confirmar senha *" autocomplete="off">
            </div>
        </div>
    </div>
</div>

<script>
    function getFormData() {
        const formData = new FormData()

        formData.append('id', $("#id").val());
        formData.append('name', $("#name").val());
        formData.append('access_id', $("#access_id").val());
        formData.append('email', $("#email").val());
        formData.append('password', $("#password").val());
        formData.append('password_confirmation', $("#password_confirmation").val());

        if ($('#photo').length) {
            if (document.getElementById('photo').files.length) {
                formData.append('photo', document.getElementById('photo')
                    .files[0])
            }
        }

        return formData;
    }

    $(function() {
        initSelects2();
    });

    function initSelects2() {
        $('#access_id').select2({
            theme: "bootstrap4",
            placeholder: "Perfis",
            allowClear: true,
        });
    }
</script>
