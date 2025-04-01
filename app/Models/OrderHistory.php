<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderHistory extends Model
{
    use SoftDeletes;

    protected $casts = [
        'data' => 'array'
    ];

    protected $fillable = [
        'order_id',
        'data',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
