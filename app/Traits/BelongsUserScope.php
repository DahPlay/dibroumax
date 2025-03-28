<?php

namespace App\Traits;

use App\Scopes\UserScope;

trait BelongsUserScope
{
    protected static function booted()
    {
        static::addGlobalScope(new UserScope());
    }
}
