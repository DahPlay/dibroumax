<?php

namespace App\Services\AppIntegration;

use App\Models\User;
use App\Services\AppIntegration\CustomerService;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Busca um usuário localmente pelo login.
     *
     * @param string $login
     * @return \App\Models\User|null
     */
    public function findUserByLogin(string $login): ?User
    {
        return User::where('login', $login)->first();
    }
}
