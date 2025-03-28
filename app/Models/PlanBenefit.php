<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanBenefit extends Model
{
    protected $fillable = ['plan_id', 'description'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
