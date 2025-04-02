<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderHistory;
use App\Services\PaymentGateway\Connectors\AsaasConnector;
use App\Services\PaymentGateway\Gateway;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BackOrderOldPlanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct (private readonly Order $order)
    {
    }

    /*
     * Este job volta a assinatura para o plano anterior, caso o cliente não pague o upgrade
     */
    public function handle (): void
    {
        $data = OrderHistory::where('order_id', $this->order->id)
            ->where('created_at', $this->order->updated_at)
            ->first();

        if ($data) {
            $adapter = app(AsaasConnector::class);
            $gateway = new Gateway($adapter);
            $data = [
                'id' => $this->order->subscription_asaas_id,
                'billingType' => $data['billing_type'],
                'value' => $data['value'],
                'nextDueDate' => $data['next_due_date'],
                'description' => $data['description'],
                'externalReference' => $data['externalReference'],
            ];

            $response = $gateway->subscription()->update($this->order->subscription_asaas_id, $data);

            if ($response['object'] === 'subscription') {
                $this->order->update([
                    "cycle" => $data['cycle'],
                    "value" => $data['value'],
                    "status" => $data['status'],
                    "plan_id" => $data['plan_id'],
                    "end_date" => $data['end_date'],
                    "description" => $data['description'],
                    "billing_type" => $data['billing_type'],
                    "changed_plan" => false,
                    "payment_date" => $data['payment_date'],
                    "next_due_date" => $data['next_due_date'],
                    "payment_status" => $data['payment_status'],
                    "original_plan_value" => null,
                ]);
            }
        }
    }
}
