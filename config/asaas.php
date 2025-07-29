<?php
$version = env('ASAAS_API_VERSION');

return [
    'sandbox' => [
        'url' => env('ASAAS_SANDBOX_URL') . '/' . $version,
        'token' => env('ASAAS_SANDBOX_TOKEN'),
        'fatura_url' => env('ASAAS_FATURA_SANDBOX_URL'),
    ],
    'production' => [
        'url' => env('ASAAS_PRODUCTION_URL') . '/' . $version,
        'token' => env('ASAAS_PRODUCTION_TOKEN'),
        'fatura_url' => env('ASAAS_FATURA_PRODUCTION_URL'),
    ],
];
