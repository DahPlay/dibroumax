<?php

namespace App\Services\PaymentGateway\Connectors\Asaas;

use App\Jobs\BackOrderOldPlanJob;
use App\Jobs\updateSubscriptionAfterProportionalPayJob;
use App\Models\Customer;
use App\Models\Order;
use App\Services\YouCast\Plan\PlanCancel;
use App\Services\YouCast\Plan\PlanCreate;
use App\Services\YouCast\Plan\PlanList;
use Illuminate\Support\Facades\Log;

class AsaasPaymentService
{
    public function processEvent (string $event, array $data): bool
    {
        $paymentId = $data['payment']['id'];
        $customerId = $data['payment']['customer'];
        $subscriptionId = $data['payment']['subscription'];
        $paymentStatus = $data['payment']['status'];
        $dueDate = $data['payment']['dueDate'];
        // $clientPaymentDate = $data['payment']['clientPaymentDate'] ?? null;

        $order = Order::where('subscription_asaas_id', $subscriptionId)->first();

        if (!$order) {
            Log::warning("Ordem não encontrada para a assinatura $subscriptionId no evento $event.");
            return false;
        }

        switch ($event) {
            case 'PAYMENT_RECEIVED':
                if ($order->changed_plan) {
                    updateSubscriptionAfterProportionalPayJob::dispatch($order);
                }
                $order->update([
                    'payment_asaas_id' => $paymentId,
                    'payment_status' => $paymentStatus,
                    'next_due_date' => $dueDate,
                ]);

                Log::info("Pagamento confirmado para a ordem {$order->id}.");

                $customer = Customer::where('customer_id', $customerId)->first();

                $youcast = (new PlanCreate())->handle($customer->viewers_id, 861);

                if ($youcast["status"] == 1) {
                    Log::info("Plano criado no youcast para o Customer {$customer->id}.");
                }

                break;

            case 'PAYMENT_CREATED':
                $order->update([
                    'payment_asaas_id' => $paymentId,
                    'payment_status' => $paymentStatus,
                    'next_due_date' => $dueDate,
                ]);

                Log::info("Pagamento criado para a ordem {$order->id}.");
                break;

            case 'PAYMENT_CONFIRMED':
                if ($order->changed_plan) {
                    updateSubscriptionAfterProportionalPayJob::dispatch($order);
                }
                $order->update([
                    'status' => 'ACTIVE',
                    'payment_asaas_id' => $paymentId,
                    'payment_status' => $paymentStatus,
                    'next_due_date' => $dueDate,
                ]);

                Log::info("Pagamento confirmado para a ordem {$order->id}.");

                $customer = Customer::where('customer_id', $customerId)->first();

                $youcast = (new PlanCreate())->handle($customer->viewers_id, 861);

                if ($youcast["status"] == 1) {
                    Log::info("Plano criado no youcast para o Customer {$customer->id}.");
                }

                break;

            case 'PAYMENT_OVERDUE':
                if ($order->changed_plan) {
                    BackOrderOldPlanJob::dispatch($order);
                }
                $order->update(
                    ['status' => 'INACTIVE'],
                    ['payment_status' => $paymentStatus]
                );
                Log::warning("Pagamento atrasado para a ordem {$order->id}.");

                $customer = Customer::where('customer_id', $customerId)->first();

                $youcast = (new PlanList)->handle($customer->viewers_id);

                if ($youcast["status"] == 1) {
                    $youcast = (new PlanCancel())->handle($customer->viewers_id, 861);
                    Log::warning("Pacote cancelado para a Customer {$customer->customer_id}.");
                }

                break;

            case 'PAYMENT_DELETED':
                $order->update(['payment_status' => $paymentStatus]);

                Log::info("AssasPaymentService - linha 91 - Pagamento cancelado para a ordem {$order->id}.");

                break;

            default:
                Log::info("Evento de pagamento não tratado: $event");
                return false;
        }

        return true;
    }
}
