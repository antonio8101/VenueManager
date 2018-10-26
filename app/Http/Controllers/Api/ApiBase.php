<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 04:02
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoginTable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\UnauthorizedException;

class ApiBase extends Controller {

	protected $user;

	/**
	 * User ability checks
	 *
	 * @param array $abilities
	 *
	 * @return bool
	 */
	protected function can( $abilities = array() ){

		foreach ( $abilities as $ability ) {

			if (Gate::denies( $ability, $this->user )) {

				throw new UnauthorizedException("User is not authorized to <$ability>");

			}

		}

		return true;
	}

	/**
	 * User setup
	 *
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function setUser(  Request $request  ){

		$token = $request->bearerToken();

		try {

			$loginTable = LoginTable::findBy( 'token', $token );

			$this->user = User::find( $loginTable->user->id );

		} catch ( \Exception $e ) {

			Log::error($e->getMessage());

			return $this->badResponse(401, "Authentication failed");

		}

		return null;
	}

	/**
	 * @param string $httpStatusCode
	 * @param string $message
	 *
	 * @param array $data
	 *
	 * @return response
	 */
	protected function badResponse( string $httpStatusCode, string $message, $data = array() ) {

		$response = [ "isValid" => false, "message" => $message ];

		foreach ( $data as $field => $value ) {

			$response[$field] = $value;

		}

		$message = json_encode( $response );

		Log::error( "Dashboard/Api@badResponse : " . $message );

		return response( $message, $httpStatusCode )->header(
			'Content-Type', 'text/json'
		);
	}

	/**
	 * @param $data
	 *
	 * @return response
	 */
	protected function goodResponse( $data ) {

		$message = json_encode( [ "isValid" => true, "data" => $data ] );

		return response( $message, 200 )->header(
			'Content-Type', 'text/json'
		);
	}

}