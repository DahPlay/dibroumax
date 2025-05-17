<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function activeCustomers()
    {
        $customers = Customer::whereHas('orders', function ($query) {
            $query->where('status', 'ACTIVE'); // ou o status correto
        })
        ->with(['orders' => function ($query) {
            $query->where('status', 'ACTIVE');
        }])
        ->get()
        ->map(function ($customer) {
            return [
                'nome' => $customer->name,
                'cpf' => $customer->document,
                'status_plano' => optional($customer->orders->first())->status ?? 'N/A',
            ];
        });

        return response()->json($customers);
    }
}

