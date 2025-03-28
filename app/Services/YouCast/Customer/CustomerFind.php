<?php

namespace App\Services\YouCast\Customer;

use App\Services\YouCast\Concerns\YouCastClient;
use Illuminate\Support\Facades\Http;

class CustomerFind
{
    use YouCastClient;

    public function handle(string $viewersId): array
    {
        $data = [
            'data' => [
                'viewers_id' => (int) $viewersId
            ]
        ];

        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'authorization' => $this->token,
            ])->post("{$this->url}/api/customer/getDataV2", $data);

            return $response->json();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
