<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 20/10/2018
 * Time: 01:54
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class LoginTableFactory extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() {
		return 'LoginTableFactory';
	}

}