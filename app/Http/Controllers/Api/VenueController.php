<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateVenueCommand;
use App\Http\Requests\EditVenueCommand;
use App\Http\Requests\GetOneVenueQuery;
use App\Http\Requests\VenuesQuery;
use App\Models\Address;
use App\Models\Venue;
use App\Models\VenueFactory;
use Illuminate\Http\Request;

class VenueController extends ApiBase
{
	private $factory;

	public function __construct( Request $request, VenueFactory $factory ) {

		$this->middleware( 'auth:api' );

		$this->setUser( $request );

		$this->factory = $factory;

	}

	/**
	 * Returns the venues list
	 *
	 * @param VenuesQuery $request
	 *
	 * @return response
	 */
    public function getVenuesQuery( VenuesQuery $request ){

    	$params = $request->validated();

    	$venues = Venue::getList( $params ); // TODO : Creates this method

    	return $this->goodResponse( $venues );

    }

	/**
	 * Returns a Venue matching with $id
	 *
	 * @param GetOneVenueQuery $request
	 *
	 * @return response
	 */
    public function getOneVenueQuery( GetOneVenueQuery $request){

    	$venue = Venue::find( $request->id );

    	return $this->goodResponse($venue);

    }

	/**
	 * Creates a new Venue
	 *
	 * @param CreateVenueCommand $request
	 *
	 * @return response
	 */
	public function createVenueCommand( CreateVenueCommand $request ) {

		$venueData = $request->validated();

		$name = $venueData['name'];

		$address = $this->InflateObject( $venueData, new Address() );

		$venue = $this->factory->get( [ 'name' => $name, 'address' => $address ] );

		$venue->store();

		return $this->goodResponse( $venue );

	}

	/**
	 * Edits the data of a Venue
	 *
	 * @param EditVenueCommand $request
	 *
	 * @return response
	 */
    public function editVenueCommand( EditVenueCommand $request ){

	    $venueData = $request->validated();

	    $name = $venueData['name'];

	    $id = $venueData['id'];

	    $venue = Venue::find( $id );

	    $venue->name = $name;

	    foreach ( $venue->address as $field => $value ) {

		    if ( $field != 'id' && isset( $venueData[ $field ] ) ) {

			    $venue->address->$field = $venueData[ $field ];

		    }

	    }

	    $venue->store();

	    return $this->goodResponse( $venue );
    }

	/**
	 * Inflates the given object with the given array of values (matching its property)
	 *
	 * @param array $data
	 * @param object $object
	 *
	 * @return object
	 */
	public function InflateObject( $data = array(), $object ) {

		foreach ( $object as $key => $value ) {

			if ( isset( $data[ $key ] ) ) {

				$object->$key = $data[ $key ];

			}

		}

		return $object;
	}

}
