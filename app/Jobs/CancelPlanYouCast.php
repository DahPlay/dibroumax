<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Order;
use App\Services\YouCast\Plan\PlanCancel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CancelPlanYouCast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if ($this->order->status === 'INATIVO' && $this->order->next_due_date->isToday()) {
            $customer = Customer::where('id', $this->order->customer_id)->first();

            if ($customer) {
                $youcast = (new PlanCancel())->handle($customer->viewers_id, 861);

                if ($youcast["status"] == 1) {
                    Log::warning("CancelPlanYouCast - linha 41 - Pacote cancelado na API externa para a Customer {$customer->customer_id}.");
                } else {
                    Log::error("CancelPlanYouCast - linha 43 - Falha ao cancelar pacote na API externa para a Customer {$customer->customer_id}.");
                }
            }
        }
    }
}
