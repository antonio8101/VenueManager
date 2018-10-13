<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:32
 */

namespace App\Models;

class Venue extends VenueModel {

	public $id;

	public $name;

	private $address;

	/** STRONGLY TYPED FIELD */

	/**
	 * @return mixed
	 */
	public function getAddress() : Address {
		return $this->address;
	}

	/**
	 * @param mixed $address
	 */
	public function setAddress( Address $address ): void {

		$this->address = $address;

	}

	/**
	 * @param string $id
	 *
	 * @return Venue
	 */
	public static function find(string $id) : Venue{

		$model = VenueModel::find($id);

		$address = Address::find($model->address_id);

		$venue = VenueFactory::get($model->name, $address, $id);

		return $venue;

	}


	/**
	 * Create a new Venue @override in VenueModel
	 *
	 * @param Venue $venue
	 *
	 * @return string
	 */
	public static function create( Venue $venue ): string {

		$addressId = Address::create( $venue->address );

		$model = VenueModel::create( [
			'name' => $venue->name,
			'address_id' => $addressId
		] );

		return $model->id;
	}

}

