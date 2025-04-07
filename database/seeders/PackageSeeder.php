<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run (): void
    {
        $packages = [
            ['name' => 'Dahplay desativado', 'cod' => 58, 'is_active' => false],
            ['name' => 'Dahplay Superior', 'cod' => 59, 'is_active' => true],
            ['name' => 'Dahplay Completo', 'cod' => 76, 'is_active' => true],
            ['name' => 'Dahplay Premium', 'cod' => 130, 'is_active' => true],
            ['name' => 'Dahplay Premiere (Aberto)', 'cod' => 118, 'is_active' => true],
            ['name' => 'Dahplay Telecine (Aberto)', 'cod' => 129, 'is_active' => true],
            ['name' => 'Dahplay Premiere (Fechado)', 'cod' => 132, 'is_active' => true],
            ['name' => 'Dahplay Telecine (Fechado)', 'cod' => 131, 'is_active' => true],
        ];

        foreach ($packages as $package) {
            Package::updateOrCreate(
                ['name' => $package['name']],
                $package
            );
        }
    }
}
