<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 03:32
 */

namespace App\Models;

use App\Models\QueryResult;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use JsonSerializable;

class Venue extends VenueModel implements JsonSerializable {

	use SerializationTrait;


	public $id;

	public $name;

	public $address;

	public $created_at;

	public $updated_at;


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
		$this->created_at = Carbon::now();
		$this->updated_at = Carbon::now();

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

		$venue = self::getFromModel( $model );

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
	 *
	 * @return QueryResult
	 */
	public static function search( $params = array() ) {

		$skip = $params['skip'] ?? 0;
		$take = $params['take'] ?? 100;
		$userId = $params['user_id'] ?? null;
		$addressLatitude = $params['latitude'] ?? null;
		$addressLongitude = $params['latitude'] ?? null;
		$distance = $params['distance'] ?? null;
		$addressCity = $params['city'] ?? null;
		$name = $params['name'] ?? null;
		$userIdMatchingVenuesIds = [];

		Log::info(json_encode($params));

		$query = VenueModel::where('venues.id', '>', 0);

		if ( !is_null($addressCity) || (!is_null($addressLongitude) && !is_null($addressLatitude)) ) {
			$query->join('addresses', 'addresses.id', '=', 'venues.address_id');

			if (!is_null($addressCity))
				$query->where('addresses.city',  $addressCity);
				//$query->where('addresses.city', 'like', '%' . $addressCity . '%');

			if (!is_null($addressLongitude) && !is_null($addressLatitude)) {

				$extensionInKm = $distance * 0.033336;

				Log::info("Extension " . $extensionInKm );

				$query->whereBetween('latitude',array( $addressLatitude - $extensionInKm,  $addressLatitude + $extensionInKm ));
				$query->whereBetween('longitude',array( $addressLongitude - $extensionInKm,  $addressLongitude + $extensionInKm ));

				//	SELECT * FROM venues  WHERE
				//	latitude BETWEEN ({$latitude} - ({$miles}*0.033336)) AND ({$latitude} + ({$miles}*0.033336)) AND
				//	longitude BETWEEN ({$longitude} - ({$miles}*0.033336)) AND ({$longitude} + ({$miles}*0.033336));

			}

		}

		if (!is_null( $userId )) {

			// TODO : Get $userIdMatchingVenuesIds

		}

		if (!is_null($name)) {

			$query->where('venues.name', $name );

		}

		$query->skip( $skip );

		$query->take( $take );

		$query->getConnection()->enableQueryLog();

		$result = $query->get()
		      ->filter( function ($item) {
			      return $item;
		      })
		      ->map( function ( $item ) {
			      return self::getFromModel( $item );
		      });

		Log::info( $query->toSql()  );

		$totalResults = $query->count();

		return new QueryResult( $result, $totalResults, $result->count() + $skip < $totalResults );

	}

	/**
	 * Gets the domain object from a Venue Model
	 *
	 * @param $model
	 *
	 * @return mixed
	 */
	protected static function getFromModel( $model ) {

		$address = Address::find( $model->address_id );

		$venue = new Venue();

		$model->address = $address;

		foreach ( $venue as $field => $value ) {

			$venue->$field = $model->$field;

		}

		return $venue;
	}
}

