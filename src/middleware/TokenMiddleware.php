<?php
/**
 * 
 * Author: Jesús Mena
 * Email: suso.mena@gmail.com
 * Date: 27/02/15
 * 
 */

namespace Susomena\TokenAuth\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Foundation\Application;
use Response;
use Susomena\TokenAuth\Credential;

class TokenMiddleware implements Middleware{
	/**
	 * The Laravel Application
	 *
	 * @var Application
	 */
	protected $app;
	/**
	 * Create a new middleware instance.
	 *
	 * @param  Application  $app
	 * @return void
	 */
	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$token = $request->header('X-Credentials-Token');
		$credential = Credential::where('token', $token);

		if($credential->count()>0){
			if($credential->first()->get()[0]['expires']>time()) {
				return $next($request);
			} else{
				return Response::json(['code' => 401, 'reason' => 'Unauthorized'], 401);
			}
		} else{
			return Response::json(['code' => 401, 'reason' => 'Unauthorized'], 401);
		}
	}
}