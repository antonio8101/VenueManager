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

	public function jsonSerialize() {
		return [
			'User' => [
				'id'           => $this->id,
				'firstName'    => $this->firstName,
				'lastName'     => $this->lastName,
				'email'        => $this->email,
				'birthDate'    => $this->birthDate,
				'role'         => $this->role,
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
	public static function find(string $id) : User{

		$model = UserModel::find($id);

		$role = Role::find($model->role_id);

		$user = UserFactory::get(
			$model->firstName, $model->lastName, $model->password,
			$model->email, Carbon::parse($model->birth_date), $role);

		$user->id = $id;
		$user->created = $model->created_at;
		$user->updated = $model->updated_at;

		return $user;

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

}

