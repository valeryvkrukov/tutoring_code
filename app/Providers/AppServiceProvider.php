<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Session;

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
        // Временно блокируем доступ к ключу в сессии
if (session()->has('sct_admin')) {
    dd('Нашел! Костыль sct_admin всё еще используется в коде.', session('sct_admin'));
}

       if (auth()->user() == null) {
         if (Session::get('loginSession') == null) {
           return redirect('/login');
         }
       }
     }
}
