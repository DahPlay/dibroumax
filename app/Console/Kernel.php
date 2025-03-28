<?php

namespace App\Console;

use App\Jobs\CancelPlanYouCast;
use App\Models\Order;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {
            $orders = Order::where('status', 'INACTIVE')
                ->whereDate('next_due_date', today())
                ->get();

            foreach ($orders as $order) {
                CancelPlanYouCast::dispatch($order);
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
