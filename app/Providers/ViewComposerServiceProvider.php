<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        # Insert Global Variables
        View::composer("*", function ($view) {
            $routeCurrent   =   Route::getCurrentRoute();
            $titleBreadCrumb =   isset($routeCurrent->wheres["titleBreadCrumb"]) ? $routeCurrent->wheres["titleBreadCrumb"] : 'Sem título BreadCrumb';
            $title =   isset($routeCurrent->wheres["title"]) ? $routeCurrent->wheres["title"] : 'Sem título';
            $routeActive    =   Route::currentRouteName();
            $route          =   explode('.', $routeActive);
            $routeAmbient   =   $route[0] ?? null;
            $routeCrud      =   $route[1] ?? null;
            $routeMethod    =   $route[2] ?? null;

            $view
                ->with('routeCurrent', $routeCurrent)
                ->with('routeActive', $routeActive)
                ->with('route', $route)
                ->with('routeAmbient', $routeAmbient)
                ->with('routeCrud', $routeCrud)
                ->with('routeMethod', $routeMethod)
                ->with('titleBreadCrumb', $titleBreadCrumb)
                ->with('title', $title);
        });
    }
}
