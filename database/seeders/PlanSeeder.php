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
        $plans = [
            [
                'name' => 'Pacote Superior',
                'cod' => [59]
            ],
            [
                'name' => 'Pacote Completo',
                'cod' => [76]
            ],
            [
                'name' => 'Pacote Sports',
                'cod' => [118]
            ],
            [
                'name' => 'Pacote Premium',
                'cod' => [130]
            ],
            /*[
                'name' => 'Telecine(A)',
                'cod' => [129]
            ],
            [
                'name' => 'Telecine(F)',
                'cod' => [131]
            ],
            [
                'name' => 'Pacote Premiere(F)',
                'cod' => [132]
            ],*/
        ];

        foreach ($plans as $index => $data) {
            $plan = Plan::updateOrCreate(
                ['name' => $data['name']],
                [
                    'value' => rand(10, 100),
                    'cycle' => CycleAsaasEnum::MONTHLY,
                    'description' => "Plano {$data['name']}",
                    'is_active' => 1,
                    'is_best_seller' => $index === 1 ? 1 : 0,
                    'free_for_days' => 7,
                    'billing_type' => 'CREDIT_CARD',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            foreach ($data['cod'] as $code) {
                $package = Package::where('cod', $code)->first();
                $plan->packagePlans()->create([
                    'package_id' => $package->id,
                ]);
            }
        }
    }
}
