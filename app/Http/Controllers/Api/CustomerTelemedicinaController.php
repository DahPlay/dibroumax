<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerTelemedicinaController extends Controller
{
    public function activeCustomers()
    {
        $customers = Customer::whereHas('orders', function ($query) {
            $query->where('status', 'ACTIVE')
                  ->whereHas('plan', function ($q) {
                      $q->where('name', 'like', '%Telemedicina%');
                  });
        })
        ->with(['orders' => function ($query) {
            $query->where('status', 'ACTIVE')
                  ->whereHas('plan', function ($q) {
                      $q->where('name', 'like', '%Telemedicina%');
                  })
                  ->with('plan');
        }])
        ->get()
        ->map(function ($customer) {
            $order = $customer->orders->first();

            return [
                'nome' => $customer->name,
                'cpf' => $customer->document,
                'status_plano' => $order->status ?? 'N/A',
                'nome_plano' => $order->plan->name ?? 'N/A',
            ];
        });

        return response()->json($customers);
    }
}
