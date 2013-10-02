<?php namespace Nusait\UsermanagerL4\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BaseUserManagerCommand extends Command {
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	protected $config;
	public function __construct($config)
	{
		parent::__construct();
		$this->config = $config;
	}

	protected function getUserModel() {
		$userModelName = $this->config['userModelName'];
		return new $userModelName();
	}

	protected function getRoleModel() {
		$roleModelName = $this->config['roleModelName'];
		return new $roleModelName();
	}
}