<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 23/10/2018
 * Time: 20:11
 */

namespace App\Http\Requests;

use App\GlobalConsts;

class EditUserCommand extends ApiFormRequest {

	use CustomAuthorizationTrait;

	protected $abilities = [ 'CanManageUsers' ];

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
			'id'           => 'required|exists:users,id',
			'firstName'    => 'string|nullable',
			'lastName'     => 'string|nullable',
			'email'        => 'email|regex:/^.+@.+$/i',
			'password'     => 'alpha_dash|size:' . $passwordMinLength,
			'role'         => 'exists:roles,name',
			'birthDate'    => 'date',
			'profileImage' => 'image',
		];

	}

}