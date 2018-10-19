<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:56
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserFactory {

	/**
	 * @param $firstName
	 * @param $lastName
	 * @param $password
	 * @param $email
	 * @param Carbon $birthDate
	 * @param Role $role
	 * @param Carbon|null $lastActivity
	 * @param null $id
	 *
	 * @return User
	 */
	public function get( $firstName, $lastName, $password, $email, Carbon $birthDate, Role $role, Carbon $lastActivity = null, $id = null ): User {

		$user = new User();

		$user->firstName = $firstName;
		$user->lastName  = $lastName;
		$user->setEmail( $email );
		$user->setBirthDate( $birthDate );
		$user->setRole( $role );

		$user->password  = Hash::make($password);

		if ( $lastActivity != null ) {
			$user->setLastActivity( $lastActivity );
		}

		$user->id = $id;

		return $user;

	}


}