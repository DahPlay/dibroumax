<?php

namespace App\Services\YouCast\Plan;

use App\Services\YouCast\Concerns\YouCastClient;
use Illuminate\Support\Facades\Http;

class PlanHistory
{
    use YouCastClient;

    public function handle(int $viewersId): array
    {
        $data = [
            'data' => [
                'viewers_id' => $viewersId
            ]
        ];

        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'authorization' => $this->token,
            ])->post("{$this->url}/api/subscription/getCustomerSubscriptionInfo", $data);

            return $response->json();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
