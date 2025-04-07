<?php

namespace App\Services\AppIntegration;

use App\Models\Package;
use App\Services\YouCast\Plan\PlanCancel;
use App\Services\YouCast\Plan\PlanCreate;
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

        //adiciono o plano que não vê nada só para o cliente não ficar com a plataforma vazia
        $dahPlayDesativado = Package::where('name', 'Dahplay desativado')->first();
        (new PlanCreate())->handle($this->viewerId, $dahPlayDesativado->cod);
    }
}