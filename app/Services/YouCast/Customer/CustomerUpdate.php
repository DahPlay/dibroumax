<?php

namespace App\Services\YouCast\Customer;

use App\Models\Customer;
use App\Services\YouCast\Concerns\YouCastClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CustomerUpdate
{
    use YouCastClient;

    public function handle(Customer $customer): array
    {
        $nameParts = $this->fullName($customer->name);

        $data = [
            "data" => [
                "viewers_id" => (int) $customer->viewers_id,
                "email" => $customer->email,
                "login" => $customer->login,
                "password" => request()->password,
                "firstname" => $nameParts[0],
                "lastname" => count($nameParts) > 1
                    ? implode(' ', array_slice($nameParts, 1))
                    : '',
            ]
        ];

        Log::info("CustomerUpdate: ");
        Log::info($data);

        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'authorization' => $this->token,
            ])->put("{$this->url}/api/integration/updateMotvCustomer", $data);

            return $response->json();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    private function fullName($name): array
    {
        return explode(' ', $name);
    }
}
