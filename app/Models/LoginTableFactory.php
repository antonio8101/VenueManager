<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 20/10/2018
 * Time: 01:50
 */

namespace App\Models;

class LoginTableFactory {

	/**
	 * @param User $user
	 * @param null $token
	 * @param null $active
	 * @param null $id
	 *
	 * @return LoginTable
	 */
	public function get( User $user, $token = null, $active = null, $id = null ) : LoginTable {

		$loginTable = new LoginTable();

		$loginTable->user   = $user;
		$loginTable->active = $active ?? 1;
		$loginTable->token  = $token ?? $this->generateToken( $user );
		$loginTable->id     = $id;

		return $loginTable;

	}

	/**
	 * Generate a token for the given the User
	 *
	 * @param User $user
	 *
	 * @return string
	 */
	public function generateToken( User $user ) {

		return LoginTable::tokenCreate( $user->id );

	}

}