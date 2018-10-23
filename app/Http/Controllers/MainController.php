<?php

namespace App\Http\Controllers;

use App\Models\LoginTable;
use App\Models\SessionExpiredException;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class MainController extends Controller
{
	const APP_VIEW_NAME = "index";
	const LOGIN_ROOT_VIEW_FOLDER = "login_views";

	/**
	 * Route main view
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function index() {

		if ( Auth::check() ) {

			$user = User::find( Auth::id() );

			$userToken = $this->getUserToken( $user );

			if (is_null( $userToken ))
				return redirect('/login');

			$headers = [];

			$cookie = cookie( 'ss_tok', $userToken, 120);

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
	 * Route login
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function login() : View{

		return $this->buildView( self::LOGIN_ROOT_VIEW_FOLDER, __FUNCTION__ );

	}


	/**
	 * Route logout
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
	 */
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

	/**
	 * Get the last active User token
	 * Can't returns token if there are no active tokens
	 * or if the last token active is expired
	 *
	 * @param User $user
	 *
	 * @return mixed|null
	 */
	protected function getUserToken( User $user ) {

		try {

			$token = $user->token();

			if (is_null($token)) {

				throw new SessionExpiredException("No Active tokens for the given User");

			}

			$loginTable = LoginTable::findBy( 'token', $token );
			$loginTable->nowStoreLastActivity();

			return $token;

		} catch ( Exception $e ){

			return null;

		}

	}
}
