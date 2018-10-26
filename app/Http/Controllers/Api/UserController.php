<?php

namespace App\Http\Controllers\Api;

use App\Facades\UserFactory;
use App\Http\Requests\CreateUserCommand;
use App\Http\Requests\EditUserCommand;
use App\Http\Requests\GetOneUserQuery;
use App\Http\Requests\UsersQuery;
use App\Models\Role;
use App\Models\User;
use App\UserModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends ApiBase
{
	public function __construct( Request $request ) {

		$this->middleware('auth:api');

    	$this->setUser($request);

    }

	/**
	 * Returns a User matching with $id
	 *
	 * @param GetOneUserQuery $request
	 *
	 * @return response
	 */
	public function getOneUserQuery(GetOneUserQuery $request){

		$user = User::find( $request->id  );

		return $this->goodResponse( $user );
	}

	/**
	 * Returns the users list
	 *
	 * @param UsersQuery $request
	 *
	 * @return response
	 */
    public function getUsersQuery(UsersQuery $request) {

	    $params = $request->only('role', 'skip', 'take');

	    $users = User::getList( $params );

	    return $this->goodResponse( $users );
    }

	/**
	 * Creates a new User
	 *
	 * @param CreateUserCommand $request
	 *
	 * @return response
	 */
    public function createUserCommand(CreateUserCommand $request){

	    $properties = $request->validated();

	    $role = Role::findBy('name', $properties['role']);

	    $user = UserFactory::get(
	    	$properties['firstName'],
		    $properties['lastName'],
		    $properties['password'],
		    $properties['email'],
		    Carbon::parse($properties['birthDate']),
		    $role
	    );

	    $user->store();

	    if (isset($properties['profileImage'])) {

		    $this->setProfileImageOnUser( $request, $user );

	    }

	    return $this->goodResponse( $user );
    }


	/**
	 * Edits the User matching with id property
	 *
	 * @param EditUserCommand $request
	 *
	 * @return response
	 */
    public function editUserCommand(EditUserCommand $request){

	    $properties = $request->validated();

	    $user = User::find( $properties['id'] );

	    foreach ( $properties as $index => $property ) {

	    	if ($index != 'id') {

			    $user->updateUserProperty( $index, $property );

		    }

	    }

	    $user->store();

	    if (isset($properties['profileImage'])) {

		    $this->setProfileImageOnUser( $request, $user );

	    }

	    return $this->goodResponse( [

		    "message" => "user updated",
		    "user"    => $user

	    ] );
    }



    public function linkUserToVenueCommand(UserModel $user, Venue $venue){
    	//
    }

	/**
	 * Stores the image file on system and path to the image on the user data
	 *
	 * @param Request $request
	 * @param $user
	 */
	protected function setProfileImageOnUser( Request $request, $user ): void {
		try {

			$path = $request->profileImage->store( 'images' );

			$user->setProfileImage( $path );

		} catch ( \Exception $e ) {

			Log::error( "User Profile Image not stored" );
			Log::error( $e->getMessage() );
			Log::error( $e->getTrace() );

		}
	}

}
