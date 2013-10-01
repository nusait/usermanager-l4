<?php namespace Nusait\UsermanagerL4\Traits;

trait UserManagerRoleRelatable {
	protected function getRoleColumnString() {
		return \Config::get('usermanager-l4::database.roleColumn');
	}
    public function getRoleIdWithName($roleQuery) {
    	$role = $this->where($this->getRoleColumnString(), $roleQuery)->first();
    	if (is_null($role)) {
    		throw new \Exception("There is no role with the name '$roleQuery'", 1);
    	}
    	return $role->id;
    }
}