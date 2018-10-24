<?php

namespace App\Http\Requests;

class UsersQuery extends ApiFormRequest
{
	use CustomAuthorizationTrait;

	protected $abilities = ['CanManageUsers'];

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
    public function rules()
    {
        return [
	        'role'              => 'exists:roles,id',
	        'skip'              => 'Numeric',
	        'take'              => 'Numeric'
        ];
    }
}


