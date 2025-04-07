<?php

namespace App\Services\AppIntegration;

use App\Services\YouCast\Plan\PlanCancel;
use Illuminate\Support\Facades\Log;

class PlanCancelService
{
    public function __construct(
        protected readonly array $packageCodes,
        protected readonly int|string $viewerId,
    ) {
    }

    public function cancelPlan(): void
    {
        foreach ($this->packageCodes as $code) {
            try {
                (new PlanCancel())->handle($this->viewerId, $code);
                Log::warning(
                    "PlanCancelService - linha 26 - Pacote Código: {$code} cancelado na API externa para a Customer {$this->viewerId}."
                );
            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
                Log::error(
                    "PlanCancelService - linha 31 - Falha ao cancelar Pacote Código: {$code} na API externa para a Customer {$this->viewerId}."
                );
            }
        }
    }
}