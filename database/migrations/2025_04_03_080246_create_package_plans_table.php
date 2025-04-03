<?php

use App\Models\Package;
use App\Models\Plan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up (): void
    {
        Schema::create('package_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Package::class)->constrained('packages')->cascadeOnDelete();
            $table->foreignIdFor(Plan::class)->constrained('plans')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down (): void
    {
        Schema::dropIfExists('package_plans');
    }
};
