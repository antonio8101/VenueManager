<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:56
 */

namespace App\Models;


class VenueFactory {

	/**
	 * @param $name
	 * @param Address $address
	 * @param null $id
	 *
	 * @return Venue
	 */
	public static function get( $name, Address $address, $id = null ): Venue {

		$venue = new Venue();

		$venue->name = $name;

		$venue->setAddress( $address );

		$venue->id = $id;

		return $venue;
	}

}