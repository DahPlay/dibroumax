<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;

class MainController extends Controller
{

    public function index(): Application|View
    {
        $data = Plan::getPlansData();

        return view('site.main.index', [
            'cycles' => $data['cycles'],
            'plansByCycle' => $data['plansByCycle'],
            'activeCycle' => $data['activeCycle']
            ]);
    }
}
