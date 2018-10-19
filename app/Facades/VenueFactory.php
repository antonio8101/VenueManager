<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 14/10/2018
 * Time: 20:32
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class VenueFactory extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'VenueFactory'; }

}