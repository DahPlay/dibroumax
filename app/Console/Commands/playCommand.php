<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class playCommand extends Command
{
    protected $signature = 'play';

    protected $description = 'Command to tests';

    public function handle (): void
    {
        /*$order = Order::find(2);
        BackOrderOldPlanJob::dispatch($order);*/
    }
}
