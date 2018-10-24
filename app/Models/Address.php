<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:34
 */

namespace App\Models;

class Address extends AddressModel {

	public $id;

	public $name;

	public $street;

	public $city;

	public $zipCode;

	public $countryId;

	public $countryName;

	public $latitude;

	public $longitude;


	/**
	 * Create a new Address @override
	 *
	 * @param Address $address
	 *
	 * @return string
	 */
	public static function create(Address $address) : string {

		$model = AddressModel::create( [
			'name' => $address->name,
			'city' => $address->city,
			'zip_code' => $address->zipCode,
			'country_id' => $address->countryId,
			'country_name' => $address->countryName,
			'latitude' => $address->latitude,
			'longitude' => $address->longitude
		] );

		return $model->id;
	}


	/**
	 * Returns the Address matching with the given $ids
	 *
	 * @param string $id
	 *
	 * @return Address
	 */
	public static function find( string $id ): Address{

		$model = AddressModel::find( $id );

		return self::getFromModel( $id, $model );

	}

	/**
	 * Returns the Address Domain Object from Model
	 *
	 * @param string $id
	 * @param AddressModel $model
	 *
	 * @return mixed
	 */
	protected static function getFromModel( string $id, AddressModel $model ) {

		$address = new Address();

		$address->id        = $id;
		$address->name      = $model->name;
		$address->city      = $model->city;
		$address->street    = $model->street;
		$address->countryId = $model->country_id;
		$address->zipCode   = $model->zip_code;
		$address->longitude = $model->longitude;
		$address->latitude  = $model->latitude;

		return $address;
	}
}