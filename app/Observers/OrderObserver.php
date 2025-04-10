<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderHistory;

class OrderObserver
{
    public function updating(Order $order): void
    {
        if ($order->isDirty('plan_id')) {
            OrderHistory::create([
                'order_id' => $order->id,
                'data' => $order->getOriginal(),
            ]);
        }
    }
}
