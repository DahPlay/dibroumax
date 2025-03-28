<?php

namespace App\Services\AsaasPhp\Customer;

use App\Services\AsaasPhp\Concerns\AsaasClient;
use Illuminate\Support\Facades\Http;

class SubscriptionCreate
{
    use AsaasClient;

    public function handle(): array
    {
        try {
            return Http::withHeader('access_token', $this->token)
                ->post("{$this->url}/subscriptions", $this->data)
                ->throw()
                ->json();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
