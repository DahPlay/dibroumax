<div class="link-item-buttons d-inline-block">
    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
        <i class="fa fa fa-ellipsis-v text-dark"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-lg">
        <a href='javascript:;' class='btn-show btn btn-info dropdown-item' data-id='{{ $order->id }}'
            data-url='/{{ $routeCrud }}/show'>
            <i class='fa fa-eye'></i>
            <span class="ml-2">Ver</span>
        </a>

        {{-- @can('admin')
            <a href='javascript:;' class='btn-delete btn btn-danger dropdown-item' data-id='{{ $order->id }}'
                data-url='/{{ $routeCrud }}/delete'>
                <i class='fa fa-trash'></i>
                <span class="ml-2">Excluir</span>
            </a>
        @endcan --}}

        <a href='javascript:;' class='btn-cancel btn btn-danger dropdown-item' data-id='{{ $order->id }}'
            data-url='/{{ $routeCrud }}/cancel'>
            <i class='fa fa-lock'></i>
            <span class="ml-2">Cancelar</span>
        </a>

        <div class="dropdown-divider"></div>
    </div>
</div>
