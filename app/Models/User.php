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

	// STRING TYPES

	public $id;

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

	public $created;

	public $updated;

	/**
	 * @param User $user
	 *
	 * @return string
	 */
	protected static function encryptPassword( User $user ): string {
		return bcrypt( $user->password );
	}

	/**
	 * @param string $id
	 * @param $model
	 *
	 * @return mixed
	 */
	protected static function getFromModel( string $id, $model ) {

		$role = Role::find( $model->role_id );

		$user = UserFactory::get(
			$model->firstName, $model->lastName, $model->password,
			$model->email, Carbon::parse( $model->birth_date ), $role );

		$user->id           = $id;
		$user->profileImage = $model->profile_image;
		$user->created      = $model->created_at;
		$user->updated      = $model->updated_at;

		return $user;
	}

	public function jsonSerialize() {
		return [
			'User' => [
				'id'           => $this->id,
				'firstName'    => $this->firstName,
				'lastName'     => $this->lastName,
				'email'        => $this->email,
				'birthDate'    => $this->birthDate,
				'role'         => $this->role,
				'profileImage' => $this->profileImage,
				'created'      => $this->created,
				'updated'      => $this->updated,
			]
		];
	}

	/**
	 * @return string
	 */
	public function getEmail() : string {
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail( string $email ): void {

		// TODO : Validate EMAIL

		$this->email = $email;
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

		$role = $user->role;

		$model = UserModel::create( [
			'firstName'  => $user->firstName,
			'lastName'   => $user->lastName,
			'email'      => $user->email,
			'birth_date' => $user->birthDate,
			'role_id'    => is_null($role) ? null : $role->id,
			'password'   => self::encryptPassword( $user)
		] );

		return $model->id;
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
	 *
	 * @return bool|void
	 */
	public function store() {

		$id = User::create( $this );

		$this->id = $id;
		$this->created = Carbon::now();
		$this->updated = Carbon::now();

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
	 * @return mixed
	 */
	public static function getList( $params = array() ){

		$skip  = $params['skip'] ?? 0;
		$take  = $params['take'] ?? 100;
		$roles = [];

		return UserModel::where( 'id', '>', 0 )
		                ->where( function ( $query ) use ( $params, $roles ) {

		                	if (isset($params['role'])) {

		                		$role =
					                ( isset( $roles[ $params['role'] ] ) ) ?
						                $roles[ $params['role'] ] :
						                RoleModel::where( 'name', $params['role'] )->first();

				                $query->where( 'role_id', $role->id );

			                }

		                } )
		                ->skip( $skip )
		                ->take( $take )
		                ->get()
		                ->map( function ( $item ) {
			                return self::getFromModel( $item->id, $item );
		                } );

	}



}

