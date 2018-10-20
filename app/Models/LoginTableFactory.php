<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 20/10/2018
 * Time: 01:50
 */

namespace App\Models;

class LoginTableFactory {

	public function get( User $user, $token = null, $active = null, $id = null ) {

		$loginTable = new LoginTable();

		$loginTable->user   = $user;
		$loginTable->active = $active ?? 1;
		$loginTable->token  = $token ?? $this->generateToken( $user );
		$loginTable->id     = $id;

		return $loginTable;

	}

	public function generateToken( User $user ) {

		return "1234567889";

	}

}