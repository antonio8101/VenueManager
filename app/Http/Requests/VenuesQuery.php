<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 24/10/2018
 * Time: 15:39
 */

namespace App\Http\Requests;

class VenuesQuery extends ApiFormRequest {

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
			'user_id'           => 'exists:users,id',
			'address.longitude' => 'Numeric',
			'address.latitude'  => 'String',
			'address.city'      => 'String',
			'name'              => 'String',
			'skip'              => 'Numeric',
			'take'              => 'Numeric'
		];

	}

}