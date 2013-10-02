<?php namespace Nusait\UsermanagerL4\Traits;
use Nusait\Nuldap\NuLdap;

trait UserManagerUserRelatable {

	protected function getFirstNameColString() {
		return \Config::get('usermanager-l4::database.firstNameColumn');
	}

    protected function getLastNameColString() {
        return \Config::get('usermanager-l4::database.lastNameColumn');
    }

    protected function getEmailColString() {
        return \Config::get('usermanager-l4::database.emailColumn');
    }

    protected function getUserColString() {
        return \Config::get('usermanager-l4::database.userColumn');
    }

    protected function getRoleRelationshipName() {
        return str_plural(strtolower(\Config::get('usermanager-l4::database.roleModelName')));
    }
    
    protected function searchLdapWithNetid($netid) {
        // Production
        $ldap = new NuLdap(\Config::get('usermanager-l4::ldap.rdn'), \Config::get('usermanager-l4::ldap.password'));
        $metadata = $ldap->searchNetid($netid);
        
        /*
        For local development, no need to test ldap stuff so comment the previous two lines
        because I made that package, and it's FLAWLESS!!!

        $metadata = [
            'givenname' => ['Steve'],
            'sn' => ['Wussup'],
            'mail' => ['awesome@awesome.com']
        ];
        */

        $result[$this->getFirstNameColString()] = $metadata['givenname'][0];
        $result[$this->getLastNameColString()] = $metadata['sn'][0];
        $result[$this->getEmailColString()] = $metadata['mail'][0];

        return $result;
    }
    public function checkForUniqueNetid($netid) {
        if ( ! $this->where($this->getUserColString(), $netid)->get()->isEmpty()) {
            throw new \Exception("User with '$netid' already exists in your users table", 1);
        }
        return true;
    }
    public function addUserByNetid($netid) {
        $firstNameCol = $this->getFirstNameColString();
        $lastNameCol = $this->getLastNameColString();
        $emailCol = $this->getEmailColString();
        $userCol = $this->getUserColString();

        $userData = $this->searchLdapWithNetid($netid);

        $user = $this->newInstance();
        $user->$userCol = $netid;
        $user->$firstNameCol = $userData[$firstNameCol];
        $user->$lastNameCol = $userData[$lastNameCol];
        $user->$emailCol = $userData[$emailCol];
        $user->save();

        return $user;
    }
    public function getAllUsersWithRoles() {
        return $this->with($this->getRoleRelationshipName())->get();
    }
}