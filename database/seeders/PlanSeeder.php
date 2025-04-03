<?php

namespace Database\Seeders;

use App\Enums\CycleAsaasEnum;
use App\Models\Package;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activePackages = Package::where('name', '!=', 'Dahplay desativado')
            ->where('is_active', true)
            ->get();

        foreach ($activePackages as $index => $package) {
            $plan = Plan::updateOrCreate(
                ['name' => $package->name],
                [
                    'value' => rand(10, 100),
                    'cycle' => CycleAsaasEnum::MONTHLY,
                    'description' => "Plano {$package->name}",
                    'is_active' => 1,
                    'is_best_seller' => $index === 1 ? 1 : 0,
                    'free_for_days' => 7,
                    'billing_type' => 'CREDIT_CARD',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $plan->packagePlans()->create([
                'package_id' => $package->id,
            ]);
        }
    }
}
