<?php

namespace App\Models;

use App\Enums\BillingTypeAsaasEnum;
use App\Enums\CycleAsaasEnum;
use App\Enums\PaymentStatusOrderAsaasEnum;
use App\Enums\StatusOrderAsaasEnum;
use App\Traits\BelongsUserScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory, BelongsUserScope;

    protected $casts = [
        'next_due_date' => 'datetime',
    ];

    protected $fillable = [
        'customer_id',
        'plan_id',
        'customer_asaas_id',
        'subscription_asaas_id',
        'payment_asaas_id',
        'value',
        'cycle',
        'billing_type',
        'next_due_date',
        'end_date',
        'status',
        'payment_status',
        'description',
        'payment_date',
        'deleted_date',
    ];

    protected function cycle(): Attribute
    {
        return Attribute::make(
            get: fn($value) => CycleAsaasEnum::from($value)->getName(),
        );
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn($value) => StatusOrderAsaasEnum::from($value)->getName(),
        );
    }

    protected function paymentStatus(): Attribute
    {
        return Attribute::make(
            get: fn($value) => PaymentStatusOrderAsaasEnum::from($value)->getName(),
        );
    }

    protected function billingType(): Attribute
    {
        return Attribute::make(
            get: fn($value) => BillingTypeAsaasEnum::from($value)->getName()
        );
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
