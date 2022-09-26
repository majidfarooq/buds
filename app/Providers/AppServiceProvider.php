<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $menus = Menu::orderBy('id', 'ASC')->get();
        View::share('menus', $menus);

        $header = Menu::whereSlug('header')->with('MenuItem')->first();
        View::share('header', $header);

        $footer = Menu::whereSlug('footer')->orderBy('id', 'ASC')->first();
        View::share('footer', $footer);
    }
}
