<?php

namespace App\Providers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        //
        Inertia::share([
            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },
        ]);
        if (config('app.env') === "production") {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        Validator::extend('not_contains', function ($attribute, $value, $parameters, $validator) {
            return strpos($value, 'ـ') === false;
        });

        Validator::replacer('not_contains', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute لا يجب أن يحتوي على الحرف ـ');
        });
    }
}