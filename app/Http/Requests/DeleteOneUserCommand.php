<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 27/10/2018
 * Time: 00:55
 */

namespace App\Http\Requests;

class DeleteOneUserCommand extends ApiFormRequest {

	use CustomAuthorizationTrait;

	protected $abilities = [ 'CanDeleteUsers' ];

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
			'id' => 'exists:users,id'
		];
	}
}