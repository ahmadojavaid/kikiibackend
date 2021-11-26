<?php

namespace Agora\RtcTokenBuilder;

use Illuminate\Support\ServiceProvider;

class RtcTokenBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Agora\RtcTokenBuilder\RtcTokenBuilder');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
