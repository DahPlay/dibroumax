<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $plans = Plan::select([
            'id',
            'name',
            'value',
            'is_best_seller',
            'free_for_days',
            'description'
        ])
            ->where('is_active', 1)
            ->get();

        return view('site.main.index', compact('plans'));
    }
}
