<div class="link-item-buttons d-inline-block">
    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
        <i class="fa fa fa-ellipsis-v text-dark"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-lg">
        <a href='javascript:;' class='btn-edit btn btn-info dropdown-item' data-id='{{ $coupon->id }}'
            data-url='/{{ $routeCrud }}/edit'>
            <i class='fa fa-edit'></i>
            <span class="ml-2">Editar</span>
        </a>

         <a href='javascript:;' class='btn-delete btn btn-danger text-danger dropdown-item' data-id='{{ $coupon->id }}'
            data-url='/{{ $routeCrud }}/delete'>
            <i class='fa fa-trash'></i>
            <span class="ml-2">Excluir</span>
        </a>

        <div class="dropdown-divider"></div>
    </div>
</div>
