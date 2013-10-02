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
		$userModel = $this->getUserModel();
		$roleModel = $this->getRoleModel();
		$netid = $this->argument('netid');

		$userModel->checkForUniqueNetid($netid);

		if ($this->option('role') != '') {
			$roleName = $this->option('role');
			$roleRelationshipMethodName = $this->getRoleRelationshipName();
			$roleId = $roleModel->getRoleIdWithName($roleName);
		}

		
		$user = $userModel->addUserByNetid($netid);
		if ($this->option('role') != '') {
			$user->$roleRelationshipMethodName()->attach($roleId);
		}

		$this->info($user->first_name . " " . $user->last_name . " has been added");
		if ($this->option('role') != '') {
			$this->info("with role of '$roleName'");
		}
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