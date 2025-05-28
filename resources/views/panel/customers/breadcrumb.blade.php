<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6 d-flex align-items-center">
                <h1 class="m-0 text-dark mb-0">
                    @if(auth()->user()->access && auth()->user()->access->name === 'User')
                        Minha Conta
                    @else
                        {{ $titleBreadCrumb ?? 'Sem título de BreadCrumb' }}
                    @endif
                </h1>
                @can('admin')
                    <span class="mx-2">-</span>
                    <a href="#" id="btn-remover" data-token="{{ csrf_token() }}" data-url="/{{ $routeCrud }}/deleteAll"
                        class="btn btn-danger btn-sm">
                        <i class="fa fa-trash-restore-alt"></i>
                    </a>
                @endcan
            </div>


            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route("$routeAmbient.$routeCrud.$routeMethod") }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        @if(auth()->user()->access && auth()->user()->access->name === 'User')
                            Minha Conta
                        @else
                            {{ $titleBreadCrumb ?? 'Sem título de BreadCrumb' }}
                        @endif
                    </li>

                </ol>
            </div>
        </div>
    </div>
</div>