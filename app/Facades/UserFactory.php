<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 19/10/2018
 * Time: 23:44
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class UserFactory extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {
		return 'UserFactory';
	}

}