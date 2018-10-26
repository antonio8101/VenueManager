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
	 * @param array $data
	 * @param null $id
	 *
	 * @return Venue
	 */
	public function get( $data = array(), $id = null ) {

		$venue = new Venue();

		$venue->name = $data['name'];

		$venue->active = true;

		$venue->setAddress( $data['address'] );

		$venue->id = $id;

		return $venue;

	}

}