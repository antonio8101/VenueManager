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
use Illuminate\Support\Facades\Hash;
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

	public $birthDate;

	public $lastActivity;

	public $created;

	public $updated;

	public function jsonSerialize() {
		return [
			'User' => [
				'id'           => $this->id,
				'firstName'    => $this->firstName,
				'lastName'     => $this->lastName,
				'email'        => $this->email,
				'birthDate'    => $this->birthDate,
				'role'         => $this->role,
				'lastActivity' => $this->lastActivity,
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

	public $role;

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
	 * @return Carbon
	 */
	public function getLastActivity() : Carbon {
		return $this->lastActivity;
	}

	/**
	 * @param Carbon $lastActivity
	 */
	public function setLastActivity( Carbon $lastActivity ): void {
		$this->lastActivity = $lastActivity;
	}

	/**
	 * Creates a new User
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
			'password'   => Hash::make( $user->password )
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

}

