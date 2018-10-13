<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Models\Venue;
use App\Models\VenueFactory;

class VenueController extends ApiBase
{
    public function __construct() {
    	// User Validation
    }

    public function getVenuesQuery(){
    	//
    }

    public function getOneVenueQuery(string $id){

    	$venue = Venue::find($id);

    	return $this->goodResponse($venue);

    }

    public function createVenueCommand($venueData = []){

    	$name = $venueData['name'];

    	$address = new Address();

    	// GET ALL THE ADDRESS PROPERTY FROM PAYLOAD
    	foreach ($address as $key=>$value){
    		if (! empty($venueData[$key])) {
			    $address->$key = $venueData[$key];
		    }
	    }

    	$venue = VenueFactory::get($name, $address);

    	Venue::create( $venue );

    	return $this->goodResponse("Venue entry stored correctly with id <>");
    }

    public function editVenueCommand($venueData = [], string $venueId){
    	//
    }

}
