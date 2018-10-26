<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 26/10/2018
 * Time: 11:39
 */

namespace App\Exceptions;

use Exception;
use Throwable;

class SessionExpiredException extends Exception {

	public function __construct( string $message = "", int $code = 0, Throwable $previous = null ) {
		parent::__construct( $message, $code, $previous );
	}

	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

	public function customFunction() {
		echo "A custom function for this type of exception\n";
	}

}