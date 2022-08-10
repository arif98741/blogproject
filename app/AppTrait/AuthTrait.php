<?php
/*
 *  Project: decathlon
 *  Last Modified: 7/4/22, 5:56 PM
 * File Created: 7/4/22, 5:56 PM
 * File: AuthTrait.php
 * Path: C:/wamp64/www/blogproject/app/AppTrait/AuthTrait.php
 * Class: AuthTrait.php
 * Copyright (c) $year
 * Created by Ariful Islam
 *  All Rights Preserved By
 *  If you have any query then knock me at
 *  arif98741@gmail.com
 *  See my profile @ https://github.com/arif98741
 *
 */

namespace App\AppTrait;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

trait AuthTrait
{

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return self::getUser()->id;
    }

    /**
     * @return Authenticatable|null
     */
    public function getUser()
    {
        return Auth::user();
    }

    /**
     * @return mixed
     */
    public function getUserRoleId()
    {
        return self::getUser()->role_id;
    }

    /**
     * @param $permission
     * @return void
     */
    public function givePermissionTo($permission)
    {
        self::getUser()->givePermissionTo($permission);
    }

    /**
     * @param $role
     * @return void
     */
    public function assignRole($role)
    {
        self::getUser()->assignRole($role);
    }


    /**
     * @return mixed
     */
    public function getAllPermissions()
    {

        return self::getUser()->getAllPermissions();
    }

    /**
     * @return mixed
     */
    public function getDirectPermissions()
    {

        return self::getUser()->getDirectPermissions();
    }

    /**
     * @return mixed
     */
    public function getPermissionsViaRoles()
    {

        return self::getUser()->getPermissionsViaRoles();
    }


    /**
     * @param bool $status
     * @return bool
     */
    public function isProvider(bool $status = false): bool
    {
        $role_id = self::getUser()->role_id;
        if ($role_id == 3) {
            $status = true;
        }
        return $status;
    }

    /**
     * @param bool $status
     * @return bool
     */
    public function isSeeker(bool $status = false): bool
    {
        $role_id = self::getUser()->role_id;
        if ($role_id == 4) {
            $status = true;
        }
        return $status;
    }
}
