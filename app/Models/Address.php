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

	use SerializationTrait;


	public $id;

	public $name;

	public $street;

	public $city;

	public $zipCode;

	public $countryId;

	public $countryName;

	public $latitude;

	public $longitude;

	public $created_at;

	public $updated_at;

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

		return self::getFromModel( $model );

	}

	/**
	 * Returns the Address Domain Object from Model
	 *
	 * @param AddressModel $model
	 *
	 * @return mixed
	 */
	protected static function getFromModel( AddressModel $model ) {

		$address = new Address();

		foreach ($address as $field => $value) {

			if ( isset( $model->$field ) )
				$address->$field = $model->$field;

		}

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