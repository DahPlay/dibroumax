<?php

use App\Http\Controllers\Webhooks\AsaasWebhookController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController; // certifique-se que você criou este
use App\Http\Controllers\Api\CustomerTelemedicinaController; // certifique-se que você criou este
use App\Http\Controllers\Api\CustomerControllerFind; // certifique-se que você criou este
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Webhook do Asaas
Route::post('/webhooks/asaas', [AsaasWebhookController::class, 'handle']);

// 🔐 Login externo para API
Route::post('/login', [AuthController::class, 'login']);

// 🔒 Endpoint protegido com token (sem Sanctum)
Route::middleware('auth.api')->get('/clientes-ativos', [CustomerController::class, 'activeCustomers']);

// 🔒 Endpoint protegido com token (sem Sanctum)
Route::middleware('auth.api')->get('/clientes-ativos-telemedicina', [CustomerTelemedicinaController::class, 'activeCustomers']);

// 🔒 Endpoint protegido com token (sem Sanctum)
Route::middleware('auth.api')->get('/clientes-ativos-buscar', [CustomerControllerFind::class, 'activeCustomers']);
