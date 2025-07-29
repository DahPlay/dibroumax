@php
    $idSemPrefixo = str_replace('pay_', '', $item->payment_asaas_id);
    $environment = app()->isLocal() ? 'sandbox' : 'production';
    $urlBase = config("asaas.{$environment}.fatura_url");
@endphp

@if ($item->payment_asaas_id)
    <a href="{{ $urlBase }}/i/{{ $idSemPrefixo }}" target="_blank"
        class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver fatura">
        <i class="fa fa-file-invoice-dollar"></i> Ver fatura
    </a>
@else
    <span class="badge badge-secondary">SEM FATURA</span>
@endif
