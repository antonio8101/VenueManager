<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateVenueCommand;
use App\Http\Requests\EditVenueCommand;
use App\Http\Requests\GetOneVenueQuery;
use App\Http\Requests\VenuesQuery;
use App\Models\Address;
use App\Models\Venue;
use App\Models\VenueFactory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

    	try {

		    $params = $request->validated();

		    $this->validateGeoParams( $params );

		    $venues = Venue::getList( $params ); // TODO : Creates this method

		    return $this->goodResponse( $venues );

	    } catch ( Exception $e) {

		    return $this->badResponse(400, $e->getMessage(), $e->validationErrors ?? array());

	    }


    }

	/**
	 * @param array $params
	 *
	 * @throws Exception
	 */
    protected function validateGeoParams( $params = array() ){

    	$validationErrors = [];

    	if (isset($params['longitude']) && !isset($params['latitude'])){

    		$validationErrors['latitude'] = "latitude is required if longitude is given";

	    }

	    if (isset($params['latitude']) && !isset($params['longitude'])){

    		$validationErrors['longitude'] = "longitude is required if latitude is given";

	    }

	    if (isset($params['latitude']) && isset($params['longitude']) && !isset($params['distance'])){

		    $validationErrors['distance'] = "distance is required if latitude or longitude are given";

	    }

	    if (count($validationErrors) > 0 ){

		    $exception = new Exception("The given data was invalid.");
		    $exception->validationErrors = [ "validationErrors" => $validationErrors  ];

		    throw $exception;

	    }
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
