<?php

namespace App\Providers;

use App\Models\LoginTable;
use App\Models\PermissionModel;
use App\Exceptions\SessionExpiredException;
use App\Models\User;
use App\Models\UserModel;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
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

	    $this->setAuthorizations();

	    $this->setAuthentication();
    }

	protected function setAuthorizations(): void {

    	$systemDefinedPermissions = PermissionModel::all()->map( function ( $p ) {
			return $p->name;
		} );

		foreach ( $systemDefinedPermissions as $p ) {

			Gate::define( $p, function ( $user ) use ( $p ) {

				$role = User::find( $user->id )->role;

				$permissions = $role->permissions->map( function ( $permission ) {

					return $permission->name;

				} );

				return $permissions->contains( $p );

			} );

		}
	}

	protected function setAuthentication(): void {

    	Auth::viaRequest( 'custom-token', function ( $request ) {

			try {

				$token = $request->bearerToken();

				$loginTable = LoginTable::findBy( 'token', $token );
				$loginTable->nowStoreLastActivity();

				return UserModel::find( $loginTable->user->id );

			} catch ( SessionExpiredException $e ) {

				Log::error( $e->getMessage() );

				return null;

			} catch ( Exception $e ) {

				Log::error( $e->getMessage() );

				return null;

			}

		} );

	}
}
