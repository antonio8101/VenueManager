<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 23/10/2018
 * Time: 16:46
 */

namespace App\Exceptions;

use App\GlobalConsts;
use App\Exceptions\Api\AuthorizationException;
use Illuminate\{
	Auth\AuthenticationException, Http\Request, Support\Facades\Log, Validation\ValidationException
};
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ApiErrorRendering {

	/**
	 * This function manage as required from the API contract the exceptions
	 *
	 * @param Request $request
	 * @param $exception
	 * @param $next
	 *
	 * @return $this
	 */
	protected function customErrorRendering( Request $request, $exception, $next ) {

		if ( $request->expectsJson() ) {

			Log::error("API EXCEPTION HANDLING FOR EXCEPTION <" . get_class( $exception ) . ">");

			if ( $exception instanceof AuthorizationException ) {

				return $this->rendering($exception, 403);
			}

			if ( $exception instanceof AuthenticationException) {

				return $this->rendering($exception, 401);
			}

			if ( $exception instanceof ValidationException) {

				$msg  = $exception->getMessage();

				$e = new Exception($msg);

				$e->validationErrors = $exception->errors();

				return $this->rendering($e, 400);
			}

			if ( $exception instanceof NotFoundHttpException) {

				$e = new Exception("Page not found");

				return $this->rendering($e, 404);
			}

			return $this->rendering( $exception );
		}

		return $next();

	}


	/**
	 * Pre defined exception rendering strategy
	 *
	 * @param Exception $exception
	 * @param int $statusCode
	 *
	 * @return $this
	 */
	protected function rendering( Exception $exception, int $statusCode = 500){

		$badResponse =  [ "isValid" => false, "message" => $exception->getMessage() ];

		if (isset($exception->validationErrors)) {

			$badResponse["validationErrors"] = $exception->validationErrors;

		}

		if ($statusCode == 500 && GlobalConsts::__APP_DEBUG) {

			$badResponse["trace"] = $exception->getTraceAsString();

		}

		$message = json_encode($badResponse);

		return response( $message, $statusCode )->header(
			'Content-Type', 'text/json'
		);

	}

}