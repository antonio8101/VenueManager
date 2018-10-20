<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 13/10/2018
 * Time: 04:02
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ApiBase extends Controller {

	/**
	 * @param string $httpStatusCode
	 * @param string $message
	 *
	 * @return $this
	 */
	protected function badResponse( string $httpStatusCode, string $message ) {
		$message = json_encode( [ "isValid" => false, "message" => $message ] );

		Log::error( "Dashboard/Api@badResponse : " . $message );

		return response( $message, $httpStatusCode )->header(
			'Content-Type', 'text/json'
		);
	}

	/**
	 * @param $data
	 *
	 * @return $this
	 */
	protected function goodResponse( $data ) {

		$message = json_encode( [ "isValid" => true, "data" => $data ] );

		return response( $message, 200 )->header(
			'Content-Type', 'text/json'
		);
	}

}