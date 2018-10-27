<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 27/10/2018
 * Time: 01:54
 */

namespace App\Http\Requests;

class DeleteUserVenueCommand extends ApiFormRequest {

	use CustomAuthorizationTrait;

	protected $abilities = [ 'CanManageUsers', 'CanManageVenues' ];

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
			'venue_id' => 'required|Numeric|exists:venues,id',
			'user_id'  => 'required|Numeric|exists:users,id'
		];

	}

}