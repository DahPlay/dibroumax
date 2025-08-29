<?php

namespace App\Models;

use App\Traits\BelongsUserScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory, BelongsUserScope;

    protected $fillable = [
        'id',
        'user_id',
        'customer_id',
        'viewers_id',
        'login',
        'name',
        'document',
        'birthdate',
        'email',
        'mobile',
        'coupon_id',
        'credit_card_number',
        'credit_card_brand',
        'credit_card_token',
    ];

    protected function document(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => sanitize($value),
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
