@if ($item->is_active)
    <a href='#' class='btn-success btn btn-is-active' data-id="{{ $item->id }}" data-is-active="0"
        data-toggle="tooltip" data-placement="bottom" title="Paciente ativo">
        <i class='fa fa-lock-open'></i>
    </a>
@else
    <a href='#' class='btn-danger btn btn-info btn-is-active' data-id="{{ $item->id }}" data-is-active="1"
        data-is-active="0" data-toggle="tooltip" data-placement="bottom" title="Paciente inativo">
        <i class='fa fa-lock'></i>
    </a>
@endif
