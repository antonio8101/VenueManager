<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:32
 */

namespace App\Models;

use App\Facades\VenueFactory;

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
	 * @param array $options
	 *
	 * @return bool
	 */
	public function save( array $options = [] ) {

		if ( is_null( $this->id ) ) {

			$id = Venue::create( $this );

			$this->id = $id;

			return true;

		} else {

			$addressId = $this->address->id;

			if ( is_null( $addressId ) ) {

				throw new \InvalidArgumentException( "The Venue has not a valid Address" );

			}

			$this->address_id = $addressId;

			return parent::save( $options );

		}
	}

	/**
	 * @param string $id
	 *
	 * @return Venue
	 */
	public static function find(string $id) : Venue {

		$model = VenueModel::find($id);

		$address = Address::find($model->address_id);

		$venue = VenueFactory::get(['name' => $model->name, 'address' => $address], $id);

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

	/**
	 * Returns a list of Venues domain objects
	 *
	 * @param array $params
	 */
	public static function getList( $params = array() ) {

		$skip = $params['skip'] ?? 0;
		$take = $params['take'] ?? 0;
		$userId = $params['user_id'] ?? null;
		$addressLatitude = $params['latitude'] ?? null;
		$addressLongitude = $params['latitude'] ?? null;
		$addressCity = $params['city'];

		if (!is_null( $addressLongitude ) && !is_null( $addressLatitude )) {

			// Search for coordinates

		}

		if (!is_null( $addressCity )) {

			// Search for city

		}

		if (!is_null( $userId )) {

			// UserId

		}

		VenueModel::where('id', '>', 0)
		->skip( $skip )
		->take( $take )
		->map( function ( $item ) {
			return self::getFromModel( $item->id, $item );
		});

	}

	/**
	 * Gets the domain object from a Venue Model
	 *
	 * @param string $id
	 * @param $model
	 *
	 * @return mixed
	 */
	protected static function getFromModel( string $id, $model ) {

		$address = Address::find( $model->address_id );

		$venue = VenueFactory::get( [
			'name' => $model->name,
			'address' => $address
		], $id );

		return $venue;
	}
}

