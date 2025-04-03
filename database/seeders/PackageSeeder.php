<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run (): void
    {
        $packages = [
            ['name' => 'Dahplay destivado', 'cod' => 0, 'is_active' => true],
            ['name' => 'Dahplay Superior', 'cod' => 59, 'is_active' => true],
            ['name' => 'Dahplay Completo', 'cod' => 76, 'is_active' => true],
            ['name' => 'Dahplay Premium', 'cod' => 130, 'is_active' => true],
            ['name' => 'Dahplay Premiere', 'cod' => 118, 'is_active' => true],
            ['name' => 'Dahplay Telecine', 'cod' => 129, 'is_active' => true],
        ];

        foreach ($packages as $package) {
            Package::updateOrCreate(
                ['name' => $package['name']],
                $package
            );
        }
    }
}
