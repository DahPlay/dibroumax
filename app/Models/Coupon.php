<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'percent',
        'cod',
        'observation',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
