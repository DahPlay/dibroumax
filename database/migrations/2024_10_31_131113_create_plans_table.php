<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('value', 10, 2);
            $table->text('cycle');
            $table->text('billing_type');
            $table->text('description')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_best_seller')->default(0);
            $table->integer('free_for_days')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
