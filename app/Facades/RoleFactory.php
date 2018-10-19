<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 20/10/2018
 * Time: 00:12
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class RoleFactory extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {
		return 'RoleFactory';
	}

}