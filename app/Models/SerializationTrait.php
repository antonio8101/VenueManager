<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 26/10/2018
 * Time: 17:21
 */

namespace App\Models;

use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

trait SerializationTrait {

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

				$prop = $reflection->getProperty( $property->name );

				if ( $reflection->getName() == $prop->class ) {

					$properties[ $property->name ] = $prop->getValue( $this );

				}
			}

			return $properties;

		} catch ( ReflectionException $e ) {

			throw new Exception( "Serialization error when trying to serialize an instance of <" . get_class( $this ) . ">" );

		}

	}

}