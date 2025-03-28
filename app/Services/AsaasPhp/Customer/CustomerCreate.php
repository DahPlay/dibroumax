<?php

namespace App\Services\AsaasPhp\Customer;

use App\Services\AsaasPhp\Concerns\AsaasClient;
use Illuminate\Support\Facades\Http;

class CustomerCreate
{
    use AsaasClient;

    public function handle(): array
    {
        try {
            return Http::withHeader('access_token', $this->token)
                ->post("{$this->url}/customers", $this->data)
                ->throw()
                ->json();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
