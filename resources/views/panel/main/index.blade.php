@extends("$routeAmbient.template.index")

@section('content')
    <div class="content-wrapper">
        @include("$routeAmbient.$routeCrud.breadcrumb")

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    {{-- @can('developer')
                    <div class="col-12">
                        Desenvolvedor
                    </div>
                    @endcan

                    @can('user')
                    <div class="col-12">
                        Usuário
                    </div>
                    @endcan --}}

                    @can('admin')
                        <div class="col-12">
                            <div class="row d-flex align-items-center">
                                <div class="col-lg-12">
                                    <form action="{{ route('panel.main.index') }}" class="mb-0">
                                        <div class="row">
                                            <div class="form-group col-12 col-lg-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">De:</span>
                                                    </div>
                                                    <input type="date" name="due_in_from" id="due_in_from_search"
                                                        class="form-control" value="2024-12-01">
                                                </div>
                                            </div>

                                            <div class="form-group col-12 col-lg-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Até:</span>
                                                    </div>
                                                    <input type="date" name="due_in_to" id="due_in_to_search"
                                                        class="form-control" value="2024-12-31">
                                                </div>
                                            </div>

                                            <div class="form-group col-12 col-lg-3">
                                                <button type="submit" id="btnPesquisar" class="form-control btn btn-primary"><i
                                                        class="fa fa-search"></i></button>
                                            </div>

                                            <div class="form-group col-12 col-lg-3">
                                                <button type="button" id="btnLimpar" class="form-control btn btn-primary"><i
                                                        class="fa fa-filter"></i> Limpar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-gray">
                                        <div class="inner">
                                            <h3>{{ $quantityUsers }}</h3>
                                            <p>Usuários</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-user"></i>
                                        </div>

                                        <a href="{{ route('panel.users.index') }}" class="small-box-footer">Ver todos <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-gray">
                                        <div class="inner">
                                            <h3>{{ $quantityCustomers }}</h3>
                                                @if(auth()->user()->access && auth()->user()->access->name === 'User')
                                                    <p>Minha Conta</p>
                                                @else
                                                    <p>Clientes</p>
                                                @endif

                                        </div>

                                        <div class="icon">
                                            <i class="fa fa-users"></i>
                                        </div>

                                        <a href="{{ route('panel.customers.index') }}" class="small-box-footer">Ver todos <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>


                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-gray">
                                        <div class="inner">
                                            <h3>{{ $quantityOrders }}</h3>
                                            <p>Assinaturas</p>
                                        </div>

                                        <div class="icon">
                                            <i class="fa fa-file-alt"></i>
                                        </div>

                                        <a href="{{ route('panel.orders.index') }}" class="small-box-footer">Ver todos <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">
                                    <div class="small-box bg-gray">
                                        <div class="inner">
                                            <h3>R$&nbsp;{{ number_format($totalOrders, 2, ',', '.') }}</h3>
                                            <p>Total Assinaturas</p>
                                        </div>

                                        <div class="icon">
                                            <i class="fa fa-chart-bar"></i>
                                        </div>

                                        <a href="{{ route('panel.orders.index') }}" class="small-box-footer">Ver todos <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascriptLocal')
    <script>
        $(function () {
            $(document).on('click', ".btn-edit", function (e) {
                openModal(this, e, 'modal-lg');
            });
        });
    </script>
@endsection

@includeIf("$routeAmbient.$routeCrud.local.index.head")
@includeIf("$routeAmbient.$routeCrud.local.index.javascript")