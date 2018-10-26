<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:34
 */

namespace App\Models;

use Exception;
use JsonSerializable;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

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

	public $created_at;

	public $updated_at;


	/**
	 * Returns a serialization from all the data of the object
	 * @return array|mixed
	 * @throws Exception
	 */
	public function jsonSerialize() {

		try {

			$reflection = new ReflectionClass( $this );

			$properties = array();

			foreach ( $reflection->getProperties( ReflectionProperty::IS_PUBLIC ) as $property ) {

				$prop = $reflection->getProperty($property->name);

				if ( $reflection->getName() == $prop->class ) {

					$properties[$property->name] = $prop->getValue( $this );

				}
			}

			return $properties;

		} catch ( ReflectionException $e ) {

			throw new Exception("Serialization error when trying to serialize an instance of <" . get_class( $this ) . ">");

		}

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