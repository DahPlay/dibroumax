<?php

namespace App\Jobs;

use App\Services\PaymentGateway\Connectors\Asaas\AsaasCustomerService;
use App\Services\PaymentGateway\Connectors\Asaas\AsaasPaymentService;
use App\Services\PaymentGateway\Connectors\Asaas\AsaasSubscriptionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessAsaasEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $event;
    public $data;

    public function __construct($event, $data)
    {
        $this->event = $event;
        $this->data = $data;
    }


    public function handle(): void
    {
        Log::info('fila rodou');
        if (str_starts_with($this->event, 'SUBSCRIPTION')) {
            $processed = app(AsaasSubscriptionService::class)->processEvent($this->event, $this->data);
        } elseif (str_starts_with($this->event, 'CUSTOMER')) {
            $processed = app(AsaasCustomerService::class)->processEvent($this->event, $this->data);
        } elseif (str_starts_with($this->event, 'PAYMENT')) {
            $processed = app(AsaasPaymentService::class)->processEvent($this->event, $this->data);
        } else {
            Log::warning("Evento desconhecido recebido do Asaas: $this->event", $this->data);
            $processed = false;
        }

        if (!$processed) {
            Log::error("Evento $this->event não pôde ser processado. Payload:", $this->data);
        }
    }
}
