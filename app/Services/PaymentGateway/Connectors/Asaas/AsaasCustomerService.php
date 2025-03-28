<?php

namespace App\Services\PaymentGateway\Connectors\Asaas;

use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class AsaasCustomerService
{
    public function processEvent(string $event, array $data): bool
    {
        $customerId = $data['customer']['id'];

        $customer = Customer::where('customer_asaas_id', $customerId)->first();

        if ($customer) {
            switch ($event) {
                case 'CUSTOMER_DELETED':
                    $customer->delete();
                    Log::info("Cliente $customerId deletado com sucesso.");
                    break;
                case 'CUSTOMER_UPDATED':
                    $customerData = $data['customer'];

                    $customer->update([
                        'name' => $customerData['name'] ?? $customer->name,
                        'mobile' => $customerData['mobilePhone'] ?? $customer->mobile,
                    ]);
                    Log::info("Cliente $customerId atualizado com sucesso.");
                    break;
                default:
                    Log::warning("Evento de cliente não tratado: $event.");
                    return false;
            }
            return true;
        } else {
            Log::warning("Cliente com ID $customerId não encontrado para o evento $event.");
            return false;
        }
    }
}
