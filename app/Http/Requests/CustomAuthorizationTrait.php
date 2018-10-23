<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 23/10/2018
 * Time: 11:06
 */

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

trait CustomAuthorizationTrait {

	/**
	 * User ability checks
	 *
	 * @param array $abilities
	 *
	 * @return bool
	 */
	protected function can( $abilities = array() ){

		$user = User::find( $this->user()->id );

		foreach ( $abilities as $ability ) {

			if (Gate::denies( $ability, $user )) {

				return false;

			}

		}

		return true;
	}

}