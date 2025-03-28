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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->index()
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('plan_id')
                ->index()
                ->nullable()
                ->constrained();

            $table->string('customer_asaas_id')->nullable();
            $table->string('subscription_asaas_id')->nullable();
            $table->string('payment_asaas_id')->nullable();
            $table->decimal('value', 10, 2);
            $table->string('cycle');
            $table->string('billing_type');
            $table->date('next_due_date');
            $table->date('end_date')->nullable();
            $table->string('status')->default('INACTIVE');
            $table->string('payment_status')->default('PENDING');
            $table->text('description')->nullable();
            $table->date('payment_date')->nullable();
            $table->date('deleted_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
