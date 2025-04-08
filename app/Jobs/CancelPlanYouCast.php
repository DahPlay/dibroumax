<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Package;
use App\Services\AppIntegration\PlanCancelService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancelPlanYouCast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public readonly Order $order)
    {
        //
    }

    public function handle(): void
    {
        if ($this->order->status === 'INATIVO' && $this->order->next_due_date->isToday()) {
            $customer = Customer::where('id', $this->order->customer_id)->first();

            if ($customer) {
//                $youcast = (new PlanCancel())->handle($customer->viewers_id, 861);
                $packagesToCreate = [];
                foreach ($this->order->plan->packagePlans as $packagePlan) {
                    $pack = Package::find($packagePlan->package_id);
                    $packagesToCreate[] = $pack->cod;
                };
                (new PlanCancelService($packagesToCreate, $customer))->cancelPlan();
            }
        }
    }
}
