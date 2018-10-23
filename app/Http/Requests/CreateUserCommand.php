<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 23/10/2018
 * Time: 17:36
 */

namespace App\Http\Requests;

use App\GlobalConsts;

class CreateUserCommand extends ApiFormRequest {

	use CustomAuthorizationTrait;

	protected $abilities = [ 'CanCreateUsers' ];

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

		$passwordMinLength = GlobalConsts::__PASSWORD_MIN_LENGTH__;

		return [
			'firstName'    => 'required',
			'lastName'     => 'required',
			'email'        => 'required|unique:users,email|regex:/^.+@.+$/i',
			'password'     => 'required|alpha_dash|size:' . $passwordMinLength,
			'role'         => 'required|exists:roles,name',
			'birthDate'    => 'required|date',
			'profileImage' => 'image',
		];

	}

	public function messages() {

		return [
			'firstname' => 'First Name of the User is required',
			#'surname' => 'Surname of the User is required'
		];

	}

}

