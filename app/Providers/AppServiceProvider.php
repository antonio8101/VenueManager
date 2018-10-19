<?php

namespace App\Providers;

use App\Models\VenueFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
	    $this->app->bind('VenueFactory', function() {

	    	return new VenueFactory();

	    });

    }


}
