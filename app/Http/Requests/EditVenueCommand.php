<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 25/10/2018
 * Time: 14:08
 */

namespace App\Http\Requests;

class EditVenueCommand extends ApiFormRequest {

	use CustomAuthorizationTrait;

	protected $abilities = [ 'CanManageVenues' ];

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
			'id'          => 'required|exists:venues',
			'longitude'   => 'required|Numeric',
			'latitude'    => 'required|Numeric',
			'street'      => 'required|String',
			'zipCode'     => 'required|String',
			'countryId'   => 'required|String',
			'countryName' => 'required|String',
			'city'        => 'required|String',
			'name'        => 'required|String'
		];

	}

}