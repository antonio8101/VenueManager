<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Models\Venue;
use App\Models\VenueFactory;

class VenueController extends ApiBase
{
	private $factory;

    public function __construct(VenueFactory $factory) {

	    //$this->middleware('auth-api');

	    $this->factory = $factory;

    }

    public function getVenuesQuery(){
    	//
    }

    public function getOneVenueQuery(string $id){

    	$venue = Venue::find($id);

    	return $this->goodResponse($venue);

    }

	/**
	 * API - Command : Creates a new Venue
	 *
	 * @param array $venueData
	 *
	 * @return $this
	 */
	public function createVenueCommand( $venueData = [] ) {

		$name = $venueData['name'];

		$address = $this->InflateObject( $venueData, new Address() );

		$venue = $this->factory->get( [ 'name' => $name, 'address' => $address ] );

		$venue->save();

		return $this->goodResponse( "Venue entry stored correctly" );

	}

    public function editVenueCommand($venueData = [], string $venueId){

		//

    }

	/**
	 * Inflates the given object with the given array of values (matching its property)
	 * @param array $data
	 * @param object $object
	 *
	 * @return object
	 */
	public function InflateObject( $data = array(), $object ) {

		foreach ( $object as $key => $value ) {

			if ( ! empty( $data[ $key ] ) ) {

				$object->$key = $data[ $key ];

			}

		}

		return $object;
	}

}
