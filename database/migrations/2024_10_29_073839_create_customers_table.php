<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->index()
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('customer_id')->nullable()->index();
            $table->integer('viewers_id')->nullable();
            $table->string('login');
            $table->string('name');
            $table->string('document')->unique()->nullable();
            $table->date('birthdate')->nullable();
            $table->string('email')->index()->unique();
            $table->string('mobile')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
