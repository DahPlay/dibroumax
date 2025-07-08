<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    @if(auth()->user()->access && auth()->user()->access->name === 'User')
                        Usuário
                    @else
                        {{ $titleBreadCrumb ?? 'Sem título de BreadCrumb' }}
                    @endif

                    <a href="#" class="btn btn-success btn-add" data-url="/{{ $routeCrud }}/create">
                        <i class="fa fa-plus"></i>
                    </a>
                    -
                    <a href="#" id="btn-remover" data-token={{ csrf_token() }} data-url="/{{ $routeCrud }}/deleteAll"
                        class="btn btn-danger">
                        <i class="fa fa-trash-restore-alt"></i>
                    </a>
                </h1>
            </div>

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route("$routeAmbient.$routeCrud.$routeMethod") }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        @if(auth()->user()->access && auth()->user()->access->name === 'User')
                            Usuário
                        @else
                            {{ $titleBreadCrumb ?? 'Sem título de BreadCrumb' }}
                        @endif
                    </li>

                </ol>
            </div>
        </div>
    </div>
</div>