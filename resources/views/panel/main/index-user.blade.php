@extends("$routeAmbient.template.index")

@section('content')
    <div class="content-wrapper">
        <div class="content"
            style="background-image: url('{{ config('custom.back_dash') }} '); background-size: cover; background-repeat: no-repeat; width: 100%; height: 100vh;">
        </div>
    </div>
@endsection

@section('javascriptLocal')
    <script>
        $(function() {
            $(document).on('click', ".btn-edit", function(e) {
                openModal(this, e, 'modal-lg');
            });
        });
    </script>
@endsection

@includeIf("$routeAmbient.$routeCrud.local.index.head")
@includeIf("$routeAmbient.$routeCrud.local.index.javascript")
