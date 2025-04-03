<?php

namespace App\Services\AppIntegration;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Package;
use App\Services\YouCast\Plan\PlanCancel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class PlanCancelService
{
    public function __construct(
        protected readonly Order|Model $order,
        protected readonly Customer|Model $customer,
    )
    {
    }

    public function cancelPlan(): void
    {
        $packs = $this->order->plan->packagePlans;

        if ($packs->count() > 0) {
            foreach ($packs as $pack) {
                try {
                    $package = Package::query()->where('id', $pack->package_id)->first();
                    (new PlanCancel())->handle($this->customer->viewers_id, $package->cod);
                    Log::warning(
                        "PlanCancelService - linha 30 - Pacote: {$package->name} cancelado na API externa para a Customer {$this->customer->id}."
                    );
                } catch (\Exception $exception) {
                    Log::error($exception->getMessage());
                    Log::error(
                        "PlanCancelService - linha 36 - Falha ao cancelar pacote na API externa para a Customer {$this->customer->id}."
                    );
                }
            }
        }
}
}