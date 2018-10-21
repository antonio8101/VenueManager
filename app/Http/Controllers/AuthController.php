<?php

namespace App\Http\Controllers;

use App\Facades\LoginTableFactory;
use App\Http\Controllers\Api\ApiBase;
use App\Models\LoginTable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiBase
{
    public function login(Request $request){

    	$credentials = $request->only('email', 'password');

    	if (Auth::attempt($credentials)) {

    		$user = User::find(Auth::id());

		    $loginTable = LoginTableFactory::get( $user );

		    LoginTable::create( $loginTable );

    		return $this->goodResponse([
    			'token' => $loginTable->token,
    			'dashboard_url' => '/'
		    ]);

	    }

	    return $this->badResponse(401, json_encode($credentials));
    }

}
