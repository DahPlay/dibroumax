<?php

namespace App\Services\AppIntegration;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Package;
use App\Services\YouCast\Plan\PlanCreate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class PlanCreateService
{
    public function __construct(
        protected readonly Order|Model $order,
        protected readonly Customer|Model $customer,
    ) {
        //
    }

    public function createPlan(): void
    {
        $packs = $this->order->plan->packagePlans;

        if ($packs->count() > 0) {
            foreach ($packs as $pack) {
                try {
                    $package = Package::query()->where('id', $pack->package_id)->first();
                    (new PlanCreate())->handle($this->customer->viewers_id, $package->cod);
                    Log::info(
                        "PlanCreateService - linha 31 - Plano criado no youcast para o Customer {$this->customer->id}."
                    );
                } catch (\Exception $exception) {
                    Log::error($exception->getMessage());
                    Log::error(
                        "PlanCreateService - linha 34 - Err0 ao criar plano no youcast para o Customer {$this->customer->id}."
                    );
                }
            }
        }
    }
}