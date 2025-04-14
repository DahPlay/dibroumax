<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'name',
        'cod',
        'is_active',
        'is_suspension'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_suspension' => 'boolean',
    ];

    public function packagePlans(): HasMany
    {
        return $this->hasMany(PackagePlan::class);
    }
}
