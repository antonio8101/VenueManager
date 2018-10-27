<?php

/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:31
 */

namespace App\Models;

use App\Facades\UserFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use JsonSerializable;

class User extends UserModel implements JsonSerializable {

	use SerializationTrait;


	// STRING TYPES

	public $id;

	public $active;

	public $firstName;

	public $lastName;

	public $password;

	public $rememberTokenName;

	public $profileImage;

	/** TO BE VALIDATED FIELDS **/

	public $email;

	/** STRONGLY TYPED FIELD */

	public $role;

	public $birthDate;

	public $created_at;

	public $updated_at;

	/**
	 * @param string $password
	 * @return string
	 */
	protected static function encryptPassword( string $password ): string {

		return bcrypt( $password );

	}

	/**
	 * @param string $id
	 * @param UserModel $model
	 *
	 * @return mixed
	 */
	protected static function getFromModel( string $id, UserModel $model ) {

		$role = Role::find( $model->role_id );

		$user = UserFactory::get(
			$model->firstName, $model->lastName, $model->password,
			$model->email, Carbon::parse( $model->birth_date ), $role );

		$user->id              = $id;
		$user->active          = $model->active;
		$user->profileImage    = $model->profile_image;
		$user->created_at      = $model->created_at;
		$user->updated_at      = $model->updated_at;

		return $user;
	}

	/**
	 * @return Carbon
	 */
	public function getBirthDate() : Carbon {
		return $this->birthDate;
	}

	/**
	 * @param Carbon $birthDate
	 */
	public function setBirthDate( Carbon $birthDate ): void {
		$this->birthDate = $birthDate;
	}


	/**
	 * @return Role
	 */
	public function getRole() : Role {
		return $this->role;
	}

	/**
	 * @param Role $role
	 */
	public function setRole( Role $role ): void {
		$this->role = $role;
	}

	/**
	 * Creates a new User
	 * Encrypts Password on user creation
	 *
	 * @param User $user
	 *
	 * @return mixed
	 */
	public static function create( User $user ){

		$userAttributes = self::getUserAttributes( $user );

		$model = UserModel::create( $userAttributes );

		return $model->id;
	}

	/**
	 * @param User $user
	 *
	 * @return array
	 */
	public static function getUserAttributes( User $user ): array {

		$role = $user->role;

		return [
			'firstName'  => $user->firstName,
			'active'     => $user->active,
			'lastName'   => $user->lastName,
			'email'      => $user->email,
			'birth_date' => $user->birthDate,
			'role_id'    => is_null($role) ? null : $role->id,
			'password'   => self::encryptPassword( $user->password )
		];

	}

	/**
	 * Finds a User by id
	 *
	 * @param string $id
	 *
	 * @return User
	 */
	public static function find(string $id) {

		$model = UserModel::find($id);

		if (is_null($model))
			return null;

		return self::getFromModel( $id, $model);
	}

	public function logout(){

		try {

			LoginTable::findBy( 'user_id', $this->id )->makeInactive();

		} catch ( \Exception $e ) {

			Log::error("There were errors in logout a user : " . $e->getMessage());

		} finally {

			Auth::logout();

		}

	}

	/**
	 * Gets the user active token
	 *
	 * @return mixed
	 */
	public function token(){

		try {

			return LoginTable::findBy( 'user_id', $this->id )->token;

		} catch ( \Exception $e ) {

			//

		}

	}


	/**
	 * Creates or Updates a User in DB
	 *
	 * @return void
	 */
	public function store(): void {

		if ( !is_null( $this->id ) ) {

			$attributes = self::getUserAttributes( $this );

			$model = UserModel::find($this->id);

			$model->fill( $attributes );

			if ( !UserModel::where('email', $model->email)->where('id', '!=', $model->id)->count() > 0 ) {

				$model->save();

			}

			return;

		}

		$id = User::create( $this );

		$this->id = $id;
		$this->created_at = Carbon::now();
		$this->updated_at = Carbon::now();

	}


	/**
	 * Sets an image path on the user record and update the object property
	 *
	 * @param string $path
	 */
	public function setProfileImage( string $path ) {

		$model = UserModel::find( $this->id );
		$model->profile_image = $path;
		$model->save();

		$this->profileImage = $path;

	}

	/**
	 * Gets a User list
	 * Filters per Roles
	 *
	 * @param array $params
	 *
	 * @return QueryResult
	 */
	public static function search( $params = array() ){

		$skip     = $params['skip'] ?? 0;
		$take     = $params['take'] ?? 100;
		$venue_id = $params['venue_id'] ?? null;
		$roles    = [];

		// search users for venue id

		$query = UserModel::where( 'id', '>', 0 )->where('active', 1)
		                  ->where( function ( $query ) use ( $params, $roles ) {

			                  if (isset($params['role'])) {

				                  $role =
					                  ( isset( $roles[ $params['role'] ] ) ) ?
						                  $roles[ $params['role'] ] :
						                  RoleModel::where( 'name', $params['role'] )->first();

				                  $query->where( 'role_id', $role->id );

			                  }

		                  } );

		if (!is_null($venue_id)){


			$ids = UserVenue::search(['venue_id' => $venue_id])->items->map(function ($item){
				return $item->user_id;
			});

			$query->whereIn('id', $ids);

		}

		$results = $query
			->skip( $skip )
			->take( $take )
			->get()
			->map( function ( $item ) {
              return self::getFromModel( $item->id, $item );
          } );

		Log::info( $query->toSql() );

		return new QueryResult($results, $query->count(), $results->count() + $skip < $query->count());

	}


	public function updateUserProperty( $field, $value ) {

		if ( $field == "role" ) {

			$role = Role::findBy( 'name', $value );

			$this->setRole( $role );

		} else if ( $field == "birthDate" ) {

			$birthDate = Carbon::parse( $value );

			$this->birthDate = $birthDate;

		} else if ( $field == "firstName" ) {

			$this->firstName = $value;

		} else if ( $field == "lastName" ) {

			$this->lastName = $value;

		} else {

			$this->$field = $value;

		}

	}

	/**
	 * Delete by set the active flag to false
	 */
	public function softDelete(){

		UserModel::softDeleteModel($this->id);

	}

}

