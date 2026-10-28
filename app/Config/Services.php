<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use CodeIgniter\Model;
use Myth\Auth\Authentication\Passwords\PasswordValidator;
use Myth\Auth\Config\Auth as AuthConfig;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    public static function authentication(string $lib = 'local', ?Model $userModel = null, ?Model $loginModel = null, bool $getShared = true)
    {
        return \Myth\Auth\Config\Services::authentication($lib, $userModel, $loginModel, $getShared);
    }

    public static function authorization(?Model $groupModel = null, ?Model $permissionModel = null, ?Model $userModel = null, bool $getShared = true)
    {
        return \Myth\Auth\Config\Services::authorization($groupModel, $permissionModel, $userModel, $getShared);
    }

    public static function passwords(?AuthConfig $config = null, bool $getShared = true): PasswordValidator
    {
        return \Myth\Auth\Config\Services::passwords($config, $getShared);
    }
}
