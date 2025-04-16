<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('panel.main.index') }}" class="brand-link">
        <img src="{{ config('custom.favicon') }}" alt="{{ config('custom.project_name') }}"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('custom.project_name') }}</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ 'storage/' . auth()->user()->photo}}" class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name ?? 'Desconhecido' }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu"
                data-accordion="false">

                @if (auth()->user()->access_id != 1)
                    @can('admin')
                        <li class="nav-item has-treeview {{ request()->is('painel-de-controle') ? 'menu-open' : '' }}">
                            <a href="{{ route('panel.main.index') }}"
                               class="nav-link {{ request()->is('painel-de-controle') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif

                @if (auth()->user()->access_id == 1)
                    @can('user')
                        <li class="nav-item has-treeview {{ request()->is('painel-de-controle-user') ? 'menu-open' : '' }}">
                            <a href="{{ route('panel.main.index-user') }}"
                               class="nav-link {{ request()->is('painel-de-controle-user') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif

                @can('admin')
                    <li class="nav-item has-treeview {{ request()->is('users') ? 'menu-open' : '' }}">
                        <a href="{{ route('panel.users.index') }}"
                           class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                Usuários
                            </p>
                        </a>
                    </li>
                @endcan

                @can('developer')
                    <li class="nav-item has-treeview" {{ request()->is('accesses') ? 'menu-open' : '' }}>
                        <a href="{{ route('panel.accesses.index') }}"
                           class="nav-link {{ request()->is('accesses') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-key"></i>
                            <p>
                                Perfis
                            </p>
                        </a>
                    </li>
                @endcan

                @can('user')
                    <li class="nav-item has-treeview {{ request()->is('customers') ? 'menu-open' : '' }}">
                        <a href="{{ route('panel.customers.index') }}"
                           class="nav-link {{ request()->is('customers') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                Clientes
                            </p>
                        </a>
                    </li>
                @endcan

                @can('admin')
                    <li class="nav-item has-treeview {{ request()->is('plans') ? 'menu-open' : '' }}">
                        <a href="{{ route('panel.plans.index') }}"
                           class="nav-link {{ request()->is('plans') ? 'active' : '' }}">
                            <i class="nav-icon far fa-list-alt"></i>
                            <p>
                                Planos
                            </p>
                        </a>
                    </li>
                @endcan

                @can('admin')
                    <li class="nav-item has-treeview {{ request()->is('coupons') ? 'menu-open' : '' }}">
                        <a href="{{ route('panel.coupons.index') }}"
                           class="nav-link {{ request()->is('coupons') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-ticket-alt"></i>
                            <p>
                                Cupons
                            </p>
                        </a>
                    </li>
                @endcan

                @can('developer')
                    <li class="nav-item has-treeview {{ request()->is('packages') ? 'menu-open' : '' }}">
                        <a href="{{ route('panel.packages.index') }}"
                           class="nav-link {{ request()->is('packages') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-archive"></i>
                            <p>
                                Pacotes
                            </p>
                        </a>
                    </li>
                @endcan

                <li class="nav-item has-treeview {{ request()->is('orders') ? 'menu-open' : '' }}">
                    <a href="{{ route('panel.orders.index') }}"
                       class="nav-link {{ request()->is('orders') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-file-alt"></i>
                        <p>
                            Pedidos
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
