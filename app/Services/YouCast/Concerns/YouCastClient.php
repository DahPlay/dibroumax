<?php

namespace App\Services\YouCast\Concerns;

trait YouCastClient
{
    public function __construct(
        protected ?string $token = null,
        protected ?string $url = null,
        protected array $data = [],
    ) {
        $this->token = $this->gerarToken();
        $this->url = config("youcast.production.url");
    }

    private function gerarToken(): string
    {
        $login = config('youcast.production.login'); //"agroplay.api";
        $secret = config('youcast.production.secret');//"ldkjgeo29vkg99133xswrt48rq3sqyf6q4r58f8h";
        $timestamp = time();

        $stringToHash = $timestamp . $login . $secret;
        $hash = sha1($stringToHash);

        return "{$login}:{$timestamp}:{$hash}";
    }
}
