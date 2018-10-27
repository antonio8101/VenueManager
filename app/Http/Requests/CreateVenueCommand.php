<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 25/10/2018
 * Time: 14:01
 */

namespace App\Http\Requests;


class CreateVenueCommand extends ApiFormRequest {

	use CustomAuthorizationTrait;

	protected $abilities = [ 'CanCreateVenues' ];

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {

		return $this->can( $this->abilities );

	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {

		return [
			'longitude'   => 'required|Numeric',
			'latitude'    => 'required|Numeric',
			'countryId'   => 'required|String',
			'countryName' => 'required|String',
			'city'        => 'required|String',
			'street'      => 'required|String',
			'zipCode'     => 'String',
			'name'        => 'required|String'
		];

	}

}