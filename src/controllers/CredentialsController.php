<?php
/**
 * 
 * Author: Jesús Mena
 * Email: suso.mena@gmail.com
 * Date: 27/02/15
 * 
 */

namespace Susomena\TokenAuth\Controllers;

use Illuminate\Routing\Controller;
use Auth;
use Input;
use Config;
use Response;
use App\User;
use Susomena\TokenAuth\Credential;

class CredentialsController extends Controller{
	public function login(){
		if(Auth::attempt(Input::only(Config::get('credentials.username'), 'password'))){
			$username = Input::only(Config::get('credentials.username'))[Config::get('credentials.username')];

			$token = uniqid("", true);
			$expires = time() + Config::get('credentials.expires');
			$user = User::where(Config::get('credentials.username'), $username)->get()[0];
			$user_id = $user['id'];

			$credentials = Credential::with('user')->where('user_id', $user_id);

			if($credentials->count()>0) {
				$credential = $credentials->get()[0];

				if (($credential['expires']) > time())
					return $credential;

				$credential->first()->delete();
			}

			$credential = new Credential;

			$credential->token = $token;
			$credential->expires = $expires;
			$credential->user_id = $user_id;

			$credential->save();

			return $credential->with('user')->get();
		} else{
			return Response::json(['code' => 401, 'message' => 'Unauthorized'], 401);
		}
	}
}