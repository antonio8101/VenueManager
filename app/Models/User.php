<?php

/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:31
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class User extends UserModel {

	// STRING TYPES

	public $id;

	public $firstName;

	public $lastName;

	public $password;

	public $rememberTokenName;

	/** TO BE VALIDATED FIELDS **/

	private $email;

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

	/** STRONGLY TYPED FIELD */

	private $birthDate;

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


	public $lastActivity;

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

		$model = UserModel::create( [
			'firstName'  => $user->firstName,
			'lastName'   => $user->lastName,
			'email'      => $user->email,
			'birth_date' => $user->birthDate,
			'password'   => Hash::make( $user->password )
		] );

		return $model->id;
	}

}

