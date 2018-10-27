<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 27/10/2018
 * Time: 01:20
 */

namespace App\Models;

use Illuminate\Support\Facades\Log;

class UserVenue extends UserVenueModel {

	public $user;

	public $venue;

	/**
	 * Create a new Venue @override in VenueModel
	 *
	 * @param User $user
	 *
	 * @param Venue $venue
	 *
	 * @return string
	 */
	public static function create( User $user, Venue $venue ): string {

		$model = UserVenueModel::where( 'user_id', $user->id )->where( 'venue_id', $venue->id )->first() ??
		         UserVenueModel::create( [
			         'user_id'  => $user->id,
			         'venue_id' => $venue->id
		         ] );

		return $model->id;
	}

	public static function find( $id ){

		$model = UserVenueModel::find( $id );

		$userVenue = new UserVenue();
		$userVenue->user= User::find( $model->user_id );
		$userVenue->venue = Venue::find( $model->venue_id );

		return $userVenue;
	}

	public static function findBy($key, $value){

		$model = UserModel::where($key, $value)->first();

		$userVenue = new UserVenue();
		$userVenue->user= User::find( $model->user_id );
		$userVenue->venue = Venue::find( $model->venue_id );

	}

	/**
	 * @param array $params
	 *
	 * @return QueryResult
	 */
	public static function search( $params = array() ){

		$skip = $params['skip'] ?? 0;

		$take = $params['take'] ?? 0;

		$query = UserModel::where('id', '>', 0);

		if (isset($params['user_id']))
			$query->where('user_id', $params['user_id']);

		if (isset($params['venue_id']))
			$query->where('venue_id', $params['venue_id']);

		$totalResults = $query->count();

		if ($take > 0) {

			$query->skip($skip)->take($take);

		}

		$results = $query->get();

		Log::info( $query->toSql() );

		return new QueryResult($results, $results->count(),$results->count() + $skip < $totalResults);
	}

}