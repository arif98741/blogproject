<?php
/*
 *  Project: decathlon
 *  Last Modified: 7/24/22, 4:50 PM
 * File Created: 7/24/22, 4:50 PM
 * File: StoreUserLoginHistory.php
 * Path: C:/wamp64/www/blogproject/app/Listeners/StoreUserLoginHistory.php
 * Class: StoreUserLoginHistory.php
 * Copyright (c) $year
 * Created by Ariful Islam
 *  This file is created and maintained by Mediasoft. You are not allowed to change or modify any part or fully without Mediasoft concern. All Rights Preserved By Mediasoft Data Systems Limited.
 *  If you have any query then knock me at
 *  arif98741@gmail.com
 *  See my profile @ https://github.com/arif98741
 *
 */

namespace App\Listeners;

use App\Events\UserLoginAttempt;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserLoginAttemptListener
{
    public function __construct()
    {
    }


    public function handle(UserLoginAttempt $event)
    {
        $current_timestamp = Carbon::now()->toDateTimeString();

        $userinfo = $event->user;

        $userArray = $userinfo->toArray();

        return DB::table('login_attempts')->insert(
            [
                'user_id' => $userinfo->id,
                'name' => null,
                'email' => $userinfo->email,
                'ip' => request()->ip(),
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'login_status' => (in_array('role_id', $userArray)) ? 1 : 0,
                'created_at' => $current_timestamp,
                'updated_at' => $current_timestamp
            ]
        );
    }
}
