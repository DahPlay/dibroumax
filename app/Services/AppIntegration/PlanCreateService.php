<?php

namespace App\Services\AppIntegration;

use App\Services\YouCast\Plan\PlanCreate;

class PlanCreateService
{
    public function __construct(
        protected readonly array $packageCodes,
        protected readonly int|string $viewerId,
    ) {
        //
    }

    public function createPlan(): void
    {
        foreach ($this->packageCodes as $code) {

            $response = (new PlanCreate())->handle($this->viewerId, $code);

            /*if ($response['status'] === 404) {
                Log::error(
                    "PlanCreateService - Erro ao criar Plano Código: {$code} no youcast para o Customer {$this->viewerId}."
                );
            };
            Log::info(
                "PlanCreateService - Plano Código: {$code} criado no youcast para o Customer {$this->viewerId}."
            );*/
        }
    }
}