<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class AuthApiMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return response()->json(['message' => 'Token não fornecido'], 401);
        }

        $token = $matches[1];

        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Token inválido'], 401);
        }

        // Se quiser acessar o user em $request->user()
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
