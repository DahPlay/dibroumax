<?php

namespace App\Http\Controllers\Site;

use App\Enums\CycleAsaasEnum;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;

class MainController extends Controller
{

    public function index(): Application|View
    {
        $plans = Plan::query()->where('is_active', 1)
            ->get();

        $plansByCycle = $plans->groupBy('cycle');
        $cycles = $plansByCycle->keys()->mapWithKeys(fn($cycle) => [
            $cycle => CycleAsaasEnum::from($cycle)->getName()
        ]);

        $activeCycle = $plans->firstWhere('is_best_seller', true)?->cycle ?? $plansByCycle->keys()->first();

        return view('site.main.index', compact('cycles', 'plansByCycle', 'activeCycle'));
    }
}
