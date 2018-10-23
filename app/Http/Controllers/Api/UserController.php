<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\GetOneUserQuery;
use App\Http\Requests\UsersQuery;
use App\Models\User;
use App\UserModel;
use Illuminate\Http\Request;

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

    public function createUserCommand($userData = []){
    	//
    }

    public function editUserCommand($userData = [], string $userId){
    	//
    }

    public function linkUserToVenueCommand(UserModel $user, Venue $venue){
    	//
    }

}
