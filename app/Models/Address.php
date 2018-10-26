<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:34
 */

namespace App\Models;

use JsonSerializable;

class Address extends AddressModel implements JsonSerializable  {

	public $id;

	public $name;

	public $street;

	public $city;

	public $zipCode;

	public $countryId;

	public $countryName;

	public $latitude;

	public $longitude;

	public function jsonSerialize() {

		return [

			'id'          => $this->id,
			'name'        => $this->name,
			'street'      => $this->street,
			'city'        => $this->city,
			'zipCode'     => $this->zipCode,
			'countryId'   => $this->countryId,
			'countryName' => $this->countryName,
			'latitude'    => $this->latitude,
			'longitude'   => $this->longitude

		];
	}

	/**
	 * Create a new Address @override
	 *
	 * @param Address $address
	 *
	 * @return string
	 */
	public static function create( Address $address ): string {

		$addressAttributes = self::getAddressAttributes( $address );

		$model = AddressModel::create( $addressAttributes );

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

	/**
	 * Model Attributes from Domain object
	 *
	 * @param Address $address
	 *
	 * @return array
	 */
	protected static function getAddressAttributes( Address $address ): array {

		$attributes = [];

		foreach ($address as $field => $value) {

			$attributes[$field] = $value;

		}

		return $attributes;

	}


	/**
	 * Creates or Updates an Address in DB
	 */
	public function store(){

		if (!is_null( $this->id )){

			$attributes = self::getAddressAttributes( $this );

			$model = AddressModel::find( $this->id );

			$model->fill( $attributes );

			$model->save();

			return;

		}

		$id = Address::create( $this );

		$this->id = $id;
		$this->created = Carbon::now();
		$this->updated = Carbon::now();

	}
}