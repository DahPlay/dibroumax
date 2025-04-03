<?php

namespace Database\Seeders;

use App\Enums\CycleAsaasEnum;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cycles = [
            'MONTHLY' => 'Mensal',
            'YEARLY' => 'Anual'
        ];

        $plans = [
            [
                'name' => 'Dahplay Superior',
                'value' => rand(10, 100),
                'cycle' => CycleAsaasEnum::MONTHLY,
                'description' => "Plano Dahplay Superior",
                'is_active' => 1,
                'is_best_seller' => 1,
                'free_for_days' => 7,
                'billing_type' => 'CREDIT_CARD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dahplay Completo',
                'value' => rand(10, 100),
                'cycle' => CycleAsaasEnum::MONTHLY,
                'description' => "Plano Dahplay Completo",
                'is_active' => 1,
                'is_best_seller' => 0,
                'free_for_days' => 7,
                'billing_type' => 'CREDIT_CARD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dahplay Premium',
                'value' => rand(10, 100),
                'cycle' => CycleAsaasEnum::MONTHLY,
                'description' => "Plano Dahplay Premium",
                'is_active' => 1,
                'is_best_seller' => 0,
                'free_for_days' => 7,
                'billing_type' => 'CREDIT_CARD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
