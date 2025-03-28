<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $due_in_from = $this->request->get('due_in_from', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $due_in_to = $this->request->get('due_in_to', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $quantityUsers = User::when($due_in_from && $due_in_to, function ($query) use ($due_in_from, $due_in_to) {
            $query->whereBetween('created_at', [$due_in_from, $due_in_to]);
        })->count();

        $quantityCustomers = Customer::when($due_in_from && $due_in_to, function ($query) use ($due_in_from, $due_in_to) {
            $query->whereBetween('created_at', [$due_in_from, $due_in_to]);
        })->count();

        $quantityOrders = Order::when($due_in_from && $due_in_to, function ($query) use ($due_in_from, $due_in_to) {
            $query->whereBetween('created_at', [$due_in_from, $due_in_to]);
        })->count();

        $totalOrders = Order::when($due_in_from && $due_in_to, function ($query) use ($due_in_from, $due_in_to) {
            $query->whereBetween('created_at', [$due_in_from, $due_in_to]);
        })->sum('value');

        return view($this->request->route()->getName(), compact('quantityUsers', 'quantityCustomers', 'quantityOrders', 'totalOrders'));
    }


    public function indexUser()
    {
        return view('panel.main.index-user');
    }
}
