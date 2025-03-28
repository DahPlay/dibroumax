<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Gate;

class UserScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (auth()->check()) {
            if (!auth()->user()->can(['admin']) && !auth()->user()->can(['developer'])) {
                if ($model->getTable() === 'customers') {
                    $builder->where($model->getTable() . '.user_id', auth()->id());
                } elseif ($model->getTable() === 'orders') {
                    $builder->whereHas('customer', function ($query) {
                        $query->where('user_id', auth()->id());
                    });
                }
            }
        }
    }
}
