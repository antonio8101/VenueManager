<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;

class MainController extends Controller
{
	const LOGIN_ROOT_VIEW_FOLDER = "login_views";

	public function index() {
		// REDIRECT IF NOT LOGGED IN
		return redirect( '/login' );
	}

	public function login() {

		return $this->buildView( self::LOGIN_ROOT_VIEW_FOLDER, __FUNCTION__ );

	}

	public function logout() {

		return $this->buildView( self::LOGIN_ROOT_VIEW_FOLDER, __FUNCTION__ );

	}

	/**
	 * @param string $folder
	 * @param string $viewName
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	protected function buildView( string $folder, string $viewName ) {

		$appName      = env( 'APP_NAME', 'VenueManager' );
		$env          = URL::to( "/" );
		$assetsFolder = $folder . '/';
		$view         = $folder . '/' . $viewName;

		return view(
			$view,
			[
				'env'              => $env,
				'appName'          => $appName,
				'index'            => $env,
				'assetsRootFolder' => $assetsFolder,
				'refresh_id'       => 'v=' . rand( 0, 99999 )
			]
		);
	}
}
