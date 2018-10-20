<?php
/**
 * Created by PhpStorm.
 * User: Antonio
 * Date: 20/10/2018
 * Time: 01:37
 */

namespace App\Models;

class LoginTable extends LoginTableModel {

	public $id;

	public $user;

	public $token;

	public $active;

	/**
	 * @param $id
	 *
	 * @return LoginTable
	 * @throws \Exception
	 */
	public static function find( $id ){

		$model = LoginTableModel::find( $id );

		if ( is_null( $model ) )
			throw new \Exception("Token not found");

		$loginTable = new LoginTable();

		$loginTable->user   = User::find( $model->user_id );
		$loginTable->token  = $model->token;
		$loginTable->active = $model->active;

		return $loginTable;

	}

	/**
	 * @param string $key
	 * @param string $value
	 *
	 * @return LoginTable
	 * @throws \Exception
	 */
	public static function findBy( string $key, string $value ) : LoginTable {

		$model = LoginTableModel::where( $key, $value )->first();

		if ( is_null( $model ) )
			throw new \Exception("Token not found");

		$loginTable = new LoginTable();

		$loginTable->user   = User::find( $model->user_id );
		$loginTable->token  = $model->token;
		$loginTable->active = $model->active;

		return $loginTable;

	}

	/**
	 * @param LoginTable $loginTable
	 *
	 * @return mixed
	 */
	public static function create( LoginTable $loginTable ) {

		$model = LoginTableModel::create( [

			'user_id' => $loginTable->user->id,
			'token'   => $loginTable->token,
			'active'  => $loginTable->active

		] );

		return $model->id;

	}

}