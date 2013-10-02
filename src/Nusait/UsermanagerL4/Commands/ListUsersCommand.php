<?php namespace Nusait\UsermanagerL4\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ListUsersCommand extends BaseUserManagerCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'usermanager:listusers';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'List All Users With Roles';

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
		$userColumnName = $this->config['userColumn']; // default is netid
		$roleRelationship = $this->getRoleRelationshipName(); //default is roles
		$roleColumnName = $this->config['roleColumn']; // default is name

		$allUsers = $userModel->getAllUsersWithRoles();
		$output = '';
		$allUsers->each(function ($user) use ($output, $userColumnName, $roleRelationship, $roleColumnName) {
			$netid = $user->$userColumnName;
			$output .= $netid . " ";
			if ($user->$roleRelationship->isEmpty()) {
				$output .= "(has no $roleRelationship)";
			} else {
				$output .= $user->$roleRelationship->fetch($roleColumnName);
			}
			$this->info($output);
			$output = '';
		});
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
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
		);
	}

}