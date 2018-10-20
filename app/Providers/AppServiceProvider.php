<?php

namespace App\Providers;

use App\Models\LoginTableFactory;
use App\Models\RoleFactory;
use App\Models\UserFactory;
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
    public function register() {

	    $this->app->bind('VenueFactory', function() {

	    	return new VenueFactory();

	    });

	    $this->app->bind('UserFactory', function(){

	    	return new UserFactory();

	    });

	    $this->app->bind('RoleFactory', function(){

		    return new RoleFactory();

	    });

	    $this->app->bind('LoginTableFactory', function(){

		    return new LoginTableFactory();

	    });

    }


}
