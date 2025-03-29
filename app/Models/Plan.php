<?php

namespace App\Models;

use App\Enums\CycleAsaasEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'value',
        'description',
        'is_active',
        'is_best_seller',
        'cycle',
        'billing_type',
        'free_for_days',
    ];

    protected $casts = [
        'cycle' => CycleAsaasEnum::class,
    ];

    protected function value(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => str_replace(['.', ','], ['', '.'], $value),
        );
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function benefits()
    {
        return $this->hasMany(PlanBenefit::class);
    }
}
