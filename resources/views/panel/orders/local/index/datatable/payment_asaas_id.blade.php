@php
    $id = $item->payment_asaas_id;
@endphp

@if (!$id)
    <span class="badge bg-secondary">SEM FATURA</span>
@else
    @php
        $idSemPrefixo = str_replace('pay_', '', $id);
        $environment = app()->isLocal() ? 'sandbox' : 'production';
        $urlBase = config("asaas.{$environment}.fatura_url");
        $url = $urlBase . '/i/' . $idSemPrefixo;
    @endphp

    <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-primary">
        <i class="far fa-eye"></i> Ver Fatura</a>
@endif
