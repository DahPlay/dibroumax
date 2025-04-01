<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VerifyOrderPaymentAfterChangedPlanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly Order $order)
    {
    }

    public function handle(): void
    {
       /* - todo: preciso rodar um job que verifica se foi paga
    *              Rodar o job depois de quanto tempo?
         *              se não foi pago preciso restaurar
    *              se foi pago posso remover o registro?
        * */

    }
}
