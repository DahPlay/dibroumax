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
            $response = (new PlanCancel())->handle($this->viewerId, $code);

            if ($response['status'] === 404) {
                Log::error(
                    "PlanCancelService - Falha ao cancelar Pacote Código: {$code} na API externa para a Customer {$this->viewerId}."
                );
            }

            Log::warning(
                "PlanCancelService - Pacote Código: {$code} cancelado na API externa para a Customer {$this->viewerId}."
            );
        }
    }
}