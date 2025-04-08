<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run (): void
    {
        $packages = [
            ['name' => 'Dahplay - Suspensão', 'cod' => 136, 'is_active' => false],
            ['name' => 'Dahplay - Pacote Superior', 'cod' => 59, 'is_active' => true],
            ['name' => 'Dahplay - Completo', 'cod' => 76, 'is_active' => true],
            ['name' => 'Dahplay - Premium', 'cod' => 130, 'is_active' => true],
            ['name' => 'Dahplay - Premiere (A)', 'cod' => 118, 'is_active' => true],
            ['name' => 'Dahplay - Telecine (A)', 'cod' => 129, 'is_active' => true],
            ['name' => 'Dahplay - Premiere (F)', 'cod' => 132, 'is_active' => true],
            ['name' => 'Dahplay - Telecine (F)', 'cod' => 131, 'is_active' => true],
        ];

        foreach ($packages as $package) {
            Package::updateOrCreate(
                ['name' => $package['name']],
                $package
            );
        }
    }
}
