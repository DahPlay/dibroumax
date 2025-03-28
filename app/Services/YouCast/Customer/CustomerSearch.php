<?php

namespace App\Services\YouCast\Customer;

use App\Services\YouCast\Concerns\YouCastClient;
use Illuminate\Support\Facades\Http;

class CustomerSearch
{
    use YouCastClient;

    public function handle(string $userLogin): array
    {
        $data = [
            'data' => [
                'search' => [
                    'wild_search' => $userLogin
                ]
            ]
        ];

        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'authorization' => $this->token,
            ])->post("{$this->url}/api/customer/findCustomerForSales", $data);

            return $response->json();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
