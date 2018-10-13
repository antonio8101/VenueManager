<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class MainController extends Controller
{
	const LOGIN_ROOT_VIEW_FOLDER = "login_views";

	public function index() {
		// REDIRECT IF NOT LOGGED IN

		// TODO : Returns the Main JS Application (SPA)

		return redirect( '/login' );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function login() : View{

		return $this->buildView( self::LOGIN_ROOT_VIEW_FOLDER, __FUNCTION__ );

	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function logout() : View {

		return $this->buildView( self::LOGIN_ROOT_VIEW_FOLDER, __FUNCTION__ );

	}

	/**
	 * @param string $folder
	 * @param string $viewName
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	protected function buildView( string $folder, string $viewName ) : View {

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
