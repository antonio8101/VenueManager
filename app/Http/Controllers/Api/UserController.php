<?php

namespace App\Http\Controllers\Api;

use App\Facades\UserFactory;
use App\Http\Requests\CreateUserCommand;
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
	 * Creates a new User
	 *
	 * @param CreateUserCommand $request
	 *
	 * @return response
	 */
    public function createUserCommand(CreateUserCommand $request){

	    $validated = $request->validated();

	    $role = Role::findBy('name', $validated['role']);

	    $user = UserFactory::get(
	    	$validated['firstname'],
		    $validated['surname'],
		    $validated['password'],
		    $validated['email'],
		    Carbon::parse($validated['birthDate']),
		    $role
	    );

	    $user->save();

	    if (isset($validated['profileImage'])) {

	    	try {

			    $path = $request->profileImage->store('images');

			    $user->setProfileImage( $path );

		    }
		    catch (\Exception $e){

	    		Log::error("User Profile Image not stored");

		    }

	    }

	    return $this->goodResponse( $user );
    }

    public function editUserCommand($userData = [], string $userId){
    	//
    }

    public function linkUserToVenueCommand(UserModel $user, Venue $venue){
    	//
    }

}
