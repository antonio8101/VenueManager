<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\UserModel;

class UserController extends ApiBase
{

    public function __construct() {

    	//$this->middleware('auth-api');

    }

    public function getUsersQuery(){
    	//
    }

    public function getOneUserQuery(string $id){

    	$user = User::find($id);

    	return $this->goodResponse($user);

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
