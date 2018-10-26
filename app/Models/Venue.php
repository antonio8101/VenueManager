<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:32
 */

namespace App\Models;

use App\Facades\VenueFactory;
use Carbon\Carbon;
use JsonSerializable;

class Venue extends VenueModel implements JsonSerializable {

	public $id;

	public $name;

	public $address;

	public $created;

	public $updated;

	public function jsonSerialize() {
		return [
			'Venue' => [
				'id'      => $this->id,
				'name'    => $this->name,
				'address' => $this->address,
			]
		];
	}

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
	 * Creates or Updates a Venue in DB
	 */
	public function store(): void {

		if ( !is_null( $this->id ) ) {

			$attributes = self::getVenueAttributes( $this );

			$model = VenueModel::find( $this->id );

			$this->address->store();

			$model->fill( $attributes );

			$model->save();

			return;

		}

		$addressId = Address::create( $this->address );

		$id = Venue::create( $this, Address::find( $addressId ) );

		$this->id = $id;
		$this->address->id = $addressId;
		$this->created = Carbon::now();
		$this->updated = Carbon::now();

	}

	/**
	 * @param Venue $venue
	 *
	 * @return array
	 */
	protected static function getVenueAttributes( Venue $venue ): array {

		$address = $venue->address;

		return [
			'name'       => $venue->name,
			'address_id' => $address->id
		];

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
	 * @param Address $address
	 *
	 * @return string
	 */
	public static function create( Venue $venue, Address $address ): string {

		$model = VenueModel::create( [
			'name' => $venue->name,
			'address_id' => $address->id
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

