<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateUserVenueCommand;
use App\Http\Requests\DeleteUserVenueCommand;
use App\Models\User;
use App\Models\UserVenue;
use App\Models\UserVenueModel;


class UserVenueController extends ApiBase
{
	public function __construct( Request $request ) {

		$this->middleware('auth:api');

		$this->setUser($request);

	}

	/**
	 * Creates a User Venue relationship
	 *
	 * @param CreateUserVenueCommand $request
	 *
	 * @return response
	 */
    public function createUserVenueRelationCommand(CreateUserVenueCommand $request){

	    $user  = User::find( $request->user_id );

	    $venue = Venue::find( $request->venue_id );

	    UserVenue::create( $user, $venue );

	    return $this->goodResponse("User <$user->id> linked to Venue <$venue->id>");

    }

	/**
	 * Deletes a UserVenue relationship
	 *
	 * @param DeleteUserVenueCommand $request
	 *
	 * @return response
	 */
	public function deleteUserVenueRelationCommand(DeleteUserVenueCommand $request){

    	$model = UserVenueModel::where('user_id', $request->user_id)->where('venue_id', $request->venue_id)->first();

    	if (!is_null($model))
    		$model->delete();

		return $this->goodResponse("User <$request->user_id> linked to Venue <$request->venue_id>");

	}
}
