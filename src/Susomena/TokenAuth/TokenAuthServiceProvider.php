<?php namespace Susomena\TokenAuth;

use Illuminate\Support\ServiceProvider;

class TokenAuthServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		include __DIR__.'/../../routes.php';

		$this->publishes([
			__DIR__.'/../../../config/credentials.php' => config_path('credentials.php'),
			__DIR__.'/../../migrations/2015_02_27_100000_create_credentials_table.php' => base_path('database/migrations/2015_02_27_100000_create_credentials_table.php'),
		]);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}
