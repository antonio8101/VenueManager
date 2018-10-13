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

}