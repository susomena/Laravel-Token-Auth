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
		if(Auth::attempt(Input::only('email', 'password'))){
			$email = Input::only('email')['email'];

			$token = uniqid("", true);
			$expires = time() + Config::get('credentials.expires');
			$user_id = User::where('email', $email)->first()->get()[0]['id'];

			$credential = Credential::where('user_id', $user_id);

			if($credential->count()>0) {
				if (($credential->first()->get()[0]['expires']) > time()) {
					return $credential->first()->get()[0]['token'];
				} else{
					$credential->first()->delete();
				}
			}

			$credential = new Credential;

			$credential->token = $token;
			$credential->expires = $expires;
			$credential->user_id = $user_id;

			$credential->save();

			return Response::json(['token' => $token]);
		} else{
			return Response::json(['code' => 401, 'reason' => 'Unauthorized'], 401);
		}
	}
}