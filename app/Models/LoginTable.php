<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 20/10/2018
 * Time: 01:37
 */

namespace App\Models;

use App\GlobalConsts;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use JsonSerializable;
use Throwable;

class LoginTable extends LoginTableModel implements JsonSerializable {

	use SerializationTrait;


	public $id;

	public $user;

	public $token;

	public $active;

	public $duration; // int milliseconds (0)

	public $lastActivity; // datetime


	/**
	 * @param $id
	 *
	 * @return LoginTable
	 * @throws Exception
	 */
	public static function find( $id ){

		$model = LoginTableModel::find( $id );

		if ( is_null( $model ) )
			throw new Exception("Token not found");

		$loginTable = new LoginTable();

		$loginTable->user   = User::find( $model->user_id );
		$loginTable->token  = $model->token;
		$loginTable->active = $model->active;

		return $loginTable;

	}

	/**
	 * @param string $key
	 * @param string $value
	 *
	 * @return LoginTable
	 * @throws Exception
	 */
	public static function findBy( string $key, string $value ) : LoginTable {

		$model = LoginTableModel::where( $key, $value )->where('active', 1)->first();

		if ( is_null( $model ) )
			throw new Exception("Token not found");

		$loginTable = new LoginTable();

		$loginTable->id           = $model->id;
		$loginTable->user         = User::find( $model->user_id );
		$loginTable->lastActivity = Carbon::parse( $model->last_activity );
		$loginTable->duration     = $model->duration;
		$loginTable->token        = $model->token;
		$loginTable->active       = $model->active;

		return $loginTable;

	}

	/**
	 * Creates a new LoginTable item (user token)
	 * if $expireInMilliseconds is 0 no duration check will be performed
	 *
	 * @param LoginTable $loginTable
	 *
	 * @param int $expireInMilliseconds
	 *
	 * @return mixed
	 */
	public static function create( LoginTable $loginTable, int $expireInMilliseconds = -1 ) {

		self::makeOtherLoginTableInactive( $loginTable );

		$duration = self::getExpiration( $expireInMilliseconds );

		$model = LoginTableModel::create( [

			'user_id'       => $loginTable->user->id,
			'token'         => $loginTable->token,
			'active'        => $loginTable->active,
			'duration'      => $duration,
			'last_activity' => date( "Y-m-d H:i:s" ),
			'created_at'    => date( "Y-m-d H:i:s" ),
			'updated_at'    => date( "Y-m-d H:i:s" )

		] );

		return $model->id;

	}

	/**
	 * This function generates the loginTable token
	 *
	 * @param $user_id
	 * @return string
	 */
	public static function tokenCreate($user_id){

		return md5(strtotime(date("Y-m-d H:i:s")).$user_id.rand(0,1000));

	}

	/**
	 * @param $expireInMilliseconds
	 *
	 * @return int
	 */
	public static function getExpiration( $expireInMilliseconds = -1 ): int {

		Log::info($expireInMilliseconds);

		if ($expireInMilliseconds != -1)
			return $expireInMilliseconds;

		Log::info("SESSION_LIFETIME AS IN ENV FILE " . GlobalConsts::__USER_SESSION_LIFE_TIME);

		$minutes = GlobalConsts::__USER_SESSION_LIFE_TIME;

		return $minutes * 60 * 1000;

	}

	/**
	 * @param LoginTable $loginTable
	 */
	protected static function makeOtherLoginTableInactive( LoginTable $loginTable ): void {
		LoginTableModel::where( 'user_id', $loginTable->user->id )
		               ->where('active', 1)
		               ->get()
		               ->each( function ( $item ) {
			               $item->active = 0;
			               $item->save();
		               } );
	}

	/**
	 * This method makes token inactive
	 *
	 */
	public function makeInactive(){

		self::makeOtherLoginTableInactive( $this );

	}

	/**
	 * Update the last activity date
	 *
	 * @throws \App\Exceptions\SessionExpiredException
	 */
	public function nowStoreLastActivity() {

		$model = LoginTableModel::find($this->id);

		$now  = Carbon::now();

		$diff = $now->diffInSeconds($this->lastActivity) * 1000;

		Log::info( $diff . "|" . $this->duration );

		if ($this->duration > 0 &&

		    $diff > $this->duration) {

			$this->makeInactive();

			throw new \App\Exceptions\SessionExpiredException( "Session is expired. LastTime activity is greater than <" . $this->duration . "> milliseconds");

		}

		$model->last_activity = Carbon::now();

		$model->save();

	}

}

