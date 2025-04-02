<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'name',
        'cod',
        'is_active',
    ];

    protected $casts = [
        "is_active" => "boolean",
    ];
}
