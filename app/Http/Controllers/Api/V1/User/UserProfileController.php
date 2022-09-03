<?php
/*
 *
 * =================================================================
 * Project: decathlon_pro
 * Last Modified: 8/16/22, 6:31 PM
 * file: C:/wamp64/www/decathlon_pro/app/Http/Controllers/Api/V1/User/UserProfileController.php
 * class: UserProfileController.php
 * Copyright (c) 2022
 * created by Ariful Islam
 * All Rights Preserved "By Mediasoft Data Systems Limited"
 * If you have any query then knock me at
 * arif98741@gmail.com
 * See my profile @ https://github.com/arif98741
 * ========================================================================
 *
 */

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Api\V1\BaseController;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends BaseController
{
    /**
     * Get Profile Data
     * @return JsonResponse|Response
     */
    public function profile()
    {
        $user = User::with([
            'user_address',
            'user_academic_infos',
            'save_addresses',
            'profession_data',
            'language_proficiency',
            'user_other_info',
        ])->where('users.id', Auth::user()->id)
            ->first();

        if ($user == null) {
            return $this->sendError([], 'No user found');
        }

        return $this->sendResponse($user, 'Fetched user and profile data');

    }

    /**
     * Update Profile Data
     * @return JsonResponse|Response
     */
    public function updateProfile(Request $request)
    {
        $authUser = Auth::user();
        $data = [
            "full_name" => $request->full_name,
            "gender" => $request->gender,
            "wight" => $request->wight,
            "height" => $request->height,
        ];
        try {

            User::where('id', $authUser->id)
                ->update($data);
            return $this->sendResponse([], 'User information updated successfully');
        } catch (Exception $e) {

            return $this->sendError([], 'Failed to update user ' . $e->getMessage(), 500);
        }

    }


}
