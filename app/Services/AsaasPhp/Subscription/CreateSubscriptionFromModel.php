<?php

declare(strict_types=1);

namespace App\Services\AsaasPhp\Customer;

use App\Services\PaymentGateway\Connectors\AsaasConnector;
use App\Services\PaymentGateway\Gateway;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CreateSubscriptionFromModel
{
    public function __construct(
        protected Model $customer,
        protected Model $plan,
        protected Model $order,
    ) {}

    public function send(): string
    {
        $adapter = new AsaasConnector();
        $gateway = new Gateway($adapter);

        $data = [
            'customer' => $this->customer->customer_id,
            'billingType' => 'CREDIT_CARD',
            'value' => $this->plan->value,
            'nextDueDate' => now()->toDateString(),
            'cycle' => $this->plan->cycle,
            'description' => 'Pedido: ' . $this->order->id,
        ];

        $response = $gateway->subscription()->create($data);

        if (!isset($response['id']) && is_string($response['error'])) {
            Log::error("Erro ao atualizar {$this->customer->name} - {$this->plan->name}: {$response['error']}");
            return '';
        }

        if (!isset($response['id']) && is_array($response['error'])) {
            $error = $response['error'][0]['description'] ?? 'Erro de integração';
            Log::error("Erro ao atualizar {$this->customer->name} - {$this->plan->name}: {$error}");
            return '';
        }

        $this->order->subscription_asaas_id = $response['id'];
        $this->order->customer_asaas_id = $response['customer'];
        $this->order->status = $response['status'];
        $this->order->save();

        return $response['id'];
    }
}
