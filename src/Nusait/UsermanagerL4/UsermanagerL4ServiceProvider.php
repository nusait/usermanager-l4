<?php namespace Nusait\UsermanagerL4;

use Illuminate\Support\ServiceProvider;

class UsermanagerL4ServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
	
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->package('nusait/usermanager-l4');

		$this->registerAddUserCommand();
		$this->registerListUsersCommand();

		$this->commands(
			'usermanager.adduser',
			'usermanager.listusers'
		);
	}
	protected function registerAddUserCommand() {
		$this->app['usermanager.adduser'] = $this->app->share(function ($app) {
			$config = $app['config']->get('usermanager-l4::database');
		   	return new Commands\AddUserCommand($config);
		});
	}
	protected function registerListUsersCommand() {
		$this->app['usermanager.listusers'] = $this->app->share(function ($app) {
			$config = $app['config']->get('usermanager-l4::database');
		   	return new Commands\ListUsersCommand($config);
		});
	}
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}