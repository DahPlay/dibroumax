<?php

namespace App\Services\AppIntegration;

use App\Services\YouCast\Plan\PlanCreate;
use Illuminate\Support\Facades\Log;

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
        foreach ($this->packageCodes as $pack) {
            try {
                (new PlanCreate())->handle($this->viewerId, $pack->cod);
                Log::info(
                    "PlanCreateService - linha 27 - Plano Código: {$pack->cod} criado no youcast para o Customer {$this->viewerId}."
                );
            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
                Log::error(
                    "PlanCreateService - linha 32 - Erro ao criar Plano Código: {$pack->cod} no youcast para o Customer {$this->viewerId}."
                );
            }
        }
    }
}