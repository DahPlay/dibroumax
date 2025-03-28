<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PaymentGateway\Connectors\Asaas\AsaasSubscriptionService;
use App\Services\PaymentGateway\Connectors\Asaas\AsaasCustomerService;
use App\Services\PaymentGateway\Connectors\Asaas\AsaasPaymentService;
use Illuminate\Support\Facades\Log;

class AsaasWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $event = $request->input('event');

        if (str_starts_with($event, 'SUBSCRIPTION')) {
            $processed = app(AsaasSubscriptionService::class)->processEvent($event, $request->all());
        } elseif (str_starts_with($event, 'CUSTOMER')) {
            $processed = app(AsaasCustomerService::class)->processEvent($event, $request->all());
        } elseif (str_starts_with($event, 'PAYMENT')) {
            $processed = app(AsaasPaymentService::class)->processEvent($event, $request->all());
        } else {
            Log::warning("Evento desconhecido recebido do Asaas: $event", $request->all());
            $processed = false;
        }

        if (!$processed) {
            Log::error("Evento $event não pôde ser processado. Payload:", $request->all());
        }

        return response()->json(['status' => $processed ? 'success' : 'error'], 200);
    }
}
