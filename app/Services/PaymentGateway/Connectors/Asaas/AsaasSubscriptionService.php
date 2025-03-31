<?php

namespace App\Services\PaymentGateway\Connectors\Asaas;

use App\Models\Order;
use DateTime;
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

        if ($order) {
            switch ($event) {
                case 'SUBSCRIPTION_CREATED':
                    $order->status = $status;
                    break;
                case 'SUBSCRIPTION_UPDATED':
                    //todo: quando faz o update da assinatura eu preciso verificar se ela já está paga
                    // se tiver eu gero um novo registro na tabela de orders

                    if($order->payment_status === 'RECEIVED' || $order->payment_status === 'CONFIRMADO'){
                        //cria uma nova
                        $date = $nextDueDate; // Data recebida do Asaas
                        $formattedDate = DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');

                        echo $formattedDate; // Saída: 2026-03-31

                        $order = Order::create([
                            'customer_id' => $order->customer_id,
                            'plan_id' => $order->plan_id,
                            'customer_asaas_id' => $order->customer_asaas_id,
                            'value' => $value,
                            'cycle' => $cycle,
                            'billing_type' =>  $billingType,
                            'next_due_date' => $formattedDate,
                            'status' => $status,
                            'description' => $description,
                        ]);
                    }
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
