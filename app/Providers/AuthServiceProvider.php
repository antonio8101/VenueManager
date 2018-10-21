<?php

namespace App\Providers;

use App\Models\LoginTable;
use App\Models\SessionExpiredException;
use App\Models\UserModel;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('custom-token', function($request) {

        	try {

		        $token = $request->bearerToken();

		        $loginTable = LoginTable::findBy( 'token', $token );
		        $loginTable->nowStoreLastActivity();

		        return UserModel::find( $loginTable->user->id );

	        }
	        catch ( SessionExpiredException $e ){

        		Log::error( $e->getMessage() );

        		return null;

	        }
	        catch ( Exception $e) {

		        Log::error( $e->getMessage() );

        		return null;

	        }

        });
    }
}
