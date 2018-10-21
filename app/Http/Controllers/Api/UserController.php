<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\UserModel;
use Illuminate\Http\Request;

class UserController extends ApiBase
{

    public function __construct() {

    	$this->middleware('auth:api');

    }

	/**
	 * Returns the users list
	 *
	 * @param Request $request
	 *
	 * @return response
	 */
    public function getUsersQuery(Request $request) {

    	$params = $request->only('role', 'skip', 'take');

    	$users = User::getList( $params );

	    return $this->goodResponse( $users );

    }

	/**
	 * Returns a User matching with $id
	 *
	 * @param string $id
	 *
	 * @return response
	 */
    public function getOneUserQuery(string $id){

    	$user = User::find($id);

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
