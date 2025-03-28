<?php

namespace Database\Seeders;

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

        $plans = [];
        foreach ($cycles as $cycle => $name) {
            $plans[] = [
                'name'        => $name,
                'value'       => rand(10, 100),
                'cycle'       => $cycle,
                'description' => "Plano $name",
                'is_active'   => 1,
                'billing_type'   => 'CREDIT_CARD',
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        Plan::insert($plans);
    }
}
