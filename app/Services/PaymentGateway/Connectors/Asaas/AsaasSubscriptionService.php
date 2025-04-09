<?php

namespace App\Services\PaymentGateway\Connectors\Asaas;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class AsaasSubscriptionService
{
    public function processEvent(string $event, array $data): bool
    {
        $subscriptionId = $data['subscription']['id'];
        $status = $data['subscription']['status'];
        $value = $data['subscription']['value'];
        $cycle = $data['subscription']['cycle'];
        $billingType = $data['subscription']['billingType'];
        $nextDueDate = $data['subscription']['nextDueDate'];
        $description = $data['subscription']['description'];

        $order = Order::where('subscription_asaas_id', $subscriptionId)->first();
        Log::info('AsaasSubscriptionService acionado');
        if ($order) {
            switch ($event) {
                case 'SUBSCRIPTION_CREATED':
                    $order->status = $status;
                    break;
                case 'SUBSCRIPTION_UPDATED':
                    $order->status = $status;
                    $order->value = $value;
                    $order->cycle = $cycle;
                    $order->billing_type = $billingType;
                    $order->description = $description;
                    break;
                case 'SUBSCRIPTION_DELETED':
                    $order->deleted_date = $data['dateCreated'];
                    $order->status = $status;
                    break;
                case 'SUBSCRIPTION_INACTIVATED':
                    $order->status = $status;
                    break;
            }

            $order->save();
            return true;
        } else {
            Log::warning("Assinatura com ID $subscriptionId não encontrada para o evento $event.");
            return false;
        }
    }
}
