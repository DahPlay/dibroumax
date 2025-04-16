<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessAsaasEventJob;
use Illuminate\Http\Request;

class AsaasWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $event = $request->input('event');
        $data = $request->all();
        ProcessAsaasEventJob::dispatch($event, $data);
       /* if (str_starts_with($event, 'SUBSCRIPTION')) {
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

        return response()->json(['status' => $processed ? 'success' : 'error'], 200);*/
        return response()->json(['status' => 'success'], 200);
    }
}
