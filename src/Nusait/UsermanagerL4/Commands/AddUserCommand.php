<?php namespace Nusait\UsermanagerL4\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AddUserCommand extends BaseUserManagerCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'usermanager:adduser';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Add a User';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($config)
	{
		parent::__construct($config);
	}

	public function fire() {
		$user = $this->getUserModel();
		$user = $user->addUserByNetid($this->argument('netid'));
		$this->info($user->first_name . " " . $user->last_name . " has been added.");
	}

	protected function getUserModel() {
		$userModelName = $this->config['userModelName'];
		return new $userModelName();
	}

	protected function getRoleModel() {
		$roleModelName = $this->config['roleModelName'];
		return new $roleModelName();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('netid', InputArgument::REQUIRED, 'bob123'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('role', 'r', InputOption::VALUE_OPTIONAL, 'admin', null),
		);
	}

}