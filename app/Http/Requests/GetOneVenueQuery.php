<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 24/10/2018
 * Time: 15:35
 */

namespace App\Http\Requests;

class GetOneVenueQuery extends ApiFormRequest {

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
			'id' => 'exists:venues,id',
		];
	}

}