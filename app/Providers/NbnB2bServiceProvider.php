<?php

namespace App\Providers;

use App\Components\NbnB2bComponent;
use App\Components\Test\NbnB2bFailedComponent;
use App\Components\Test\NbnB2bSuccessComponent;
use Illuminate\Support\ServiceProvider;

class NbnB2bServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('NbnB2bClient' , function ($app) {
            // service provider is used to form connection with Nbn client
            // success component and failed components are used to handle order_success and failed queues
            // NbnB2bSuccessComponent can be used for mocking success response, while failed will be used for failure response
            return new NbnB2bComponent();
//            return new NbnB2bSuccessComponent();
//            return new NbnB2bFailedComponent();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
