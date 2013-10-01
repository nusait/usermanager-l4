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
    
    protected function searchLdapWithNetid($netid) {
        $ldap = new NuLdap(\Config::get('usermanager-l4::ldap.rdn'), \Config::get('usermanager-l4::ldap.password'));
        $metadata = $ldap->searchNetid($netid);

        $result[$this->getFirstNameColString()] = $metadata['givenname'][0];
        $result[$this->getLastNameColString()] = $metadata['sn'][0];
        $result[$this->getEmailColString()] = $metadata['mail'][0];

        return $result;
    }

    public function addUserByNetid($netid) {
        if ( ! $this->where($this->getUserColString(), $netid)->get()->empty()) {
            throw new \Exception("User with '$netid' already exists in your users table", 1);
        }

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
}