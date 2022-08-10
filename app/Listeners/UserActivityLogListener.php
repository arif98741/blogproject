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

use App\Events\UserActivityLogEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserActivityLogListener
{
    public function __construct()
    {
    }


    /**
     * @param UserActivityLogEvent $eventData
     * @return bool
     */
    public function handle(UserActivityLogEvent $eventData): bool
    {
      
        $current_timestamp = Carbon::now()->toDateTimeString();

        return DB::table('activity_logs')->insert(
            [
                'user_id' => $eventData->getUserId(),
                'table_name' => $eventData->getTable(),
                'row_id' => $eventData->getActionRowId(),
                'action_name' => $eventData->getAction(),
                'activity' => $eventData->getActivity(),
                'ip' => request()->ip(),
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'created_at' => $current_timestamp,
                'updated_at' => $current_timestamp
            ]
        );
    }
}
