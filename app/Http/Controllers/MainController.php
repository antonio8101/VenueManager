<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class MainController extends Controller
{
	const APP_VIEW_NAME = "index";
	const LOGIN_ROOT_VIEW_FOLDER = "login_views";

	public function index() {

		if ( Auth::check() ) {

			$user = User::find( Auth::id() );

			$headers = [];

			$cookie = cookie( 'ss_tok', $user->token(), 120);

			return response(view( self::APP_VIEW_NAME,
				[
					'appName'    => 'test',
					'refresh_id' => 'v=' . rand( 0, 99999 )
				]
			), 200, $headers)->cookie($cookie);

		}

		return redirect( '/login' );
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function login() : View{

		return $this->buildView( self::LOGIN_ROOT_VIEW_FOLDER, __FUNCTION__ );

	}


	public function logout() {

		if (!Auth::check()) {

			return redirect('/');

		}

		$user = User::find( Auth::id() );

		$user->logout();

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
