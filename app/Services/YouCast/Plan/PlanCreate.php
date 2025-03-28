<?php

namespace App\Services\YouCast\Plan;

use App\Services\YouCast\Concerns\YouCastClient;
use Illuminate\Support\Facades\Http;

class PlanCreate
{
    use YouCastClient;

    public function handle(int $viewersId, int $productsId): array
    {
        $data = [
            'data' => [
                'viewers_id' => $viewersId,
                'products_id' => $productsId,
            ]
        ];

        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'authorization' => $this->token,
            ])->post("{$this->url}/api/integration/subscribe", $data);

            return $response->json();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
