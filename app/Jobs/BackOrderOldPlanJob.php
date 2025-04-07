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
        $oldOrder = OrderHistory::where('order_id', $this->order->id)
            ->where('created_at', $this->order->updated_at)
            ->first();

        if ($oldOrder) {
            $adapter = app(AsaasConnector::class);
            $gateway = new Gateway($adapter);
            $data = [
                'id' => $this->order->subscription_asaas_id,
                'billingType' => $oldOrder['data']['billing_type'],
                'value' => $oldOrder['data']['value'],
                'nextDueDate' => $oldOrder['data']['next_due_date'],
                'description' => $oldOrder['data']['description'],
            ];

            $response = $gateway->subscription()->update($this->order->subscription_asaas_id, $data);

            if ($response['object'] === 'subscription') {

                $this->order->update([
                    "cycle" => $response['cycle'],
                    "value" => $response['value'],
                    "status" => $response['status'],
                    "plan_id" => $oldOrder['data']['plan_id'],
                    "end_date" => $oldOrder['data']['end_date'],
                    "description" => $response['description'],
                    "billing_type" => $response['billingType'],
                    "changed_plan" => false,
                    "payment_date" => $response['paymentDate'],
                    "next_due_date" => $response['nextDueDate'],
                    "payment_status" => $response['paymentStatus'],
                    "original_plan_value" => null,
                ]);
            }
        }
    }
}
