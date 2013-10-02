UserManager Artisan Command Package
-------------------------------------------
## Available Commands
```
usermanager:adduser
usermanager:listusers
```

### To Install

1. Include the following in your composer.json
```
"nusait/usermanager-l4" : "*"
```

2. Run
```
composer update
```

3. Include the following in your ```app.php``` in your config folder
```
'Nusait\UsermanagerL4\UsermanagerL4ServiceProvider',
```

4. Publish the configuration
```
php artisan config:publish nusait/usermanager-l4
```

5. Navigate to package configuration and Change the ldap configuration

6. Include Traits in your User and Role models

(User Model)
```php
 ... 
class User extends Eloquent implements UserInterface, RemindableInterface {
	use Nusait\UsermanagerL4\Traits\UserManagerUserRelatable;
 ...
```

(Role Model)
```php
 ... 
class Role extends Eloquent {
	use Nusait\UsermanagerL4\Traits\UserManagerRoleRelatable;
 ...
```

### To Use

Run (on production server)
Example:

```
php artisan usermanager:adduser netid --role="admin"
```
