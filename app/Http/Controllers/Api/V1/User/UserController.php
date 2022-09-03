<?php
/*
 *
 * =================================================================
 * Project: decathlon_pro
 * Last Modified: 8/16/22, 6:31 PM
 * file: C:/wamp64/www/decathlon_pro/app/Http/Controllers/Api/V1/User/UserController.php
 * class: UserController.php
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

use App\AppTrait\AuthTrait;
use App\Http\Controllers\Api\V1\BaseController;
use App\Models\Gallery;
use App\Models\User;
use App\Models\User\UserAddress;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class UserController extends BaseController
{
    /**
     * Get All Providers
     * @return JsonResponse|Response
     */
    public function getUsers()
    {
        $users = User::with('role')->whereIn('role_id', [3, 4])->get();

        if ($users == null) {
            return $this->sendError([], 'No user found');
        }

        return $this->sendResponse($users, 'Fetched user');
    }

    /**
     * Get All Providers
     * @return JsonResponse|Response
     */
    public function providersByStatus(Request $request)
    {
        $users = User::with('role')->whereIn('role_id', [3]);

        if ($request->has('status')) {
            $users->where('status', $request->status);
        }
        if ($request->has('available')) {
            $users->where('available', $request->available);
        }
        $users = $users->get();


        if ($users == null) {
            return $this->sendError([], 'No user found');
        }

        return $this->sendResponse($users, 'Fetched user according to given status');
    }

    /**
     * @return string
     */
    public function getUsersByRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Data validation error', $validator->errors(),);
        }

        $allowed_params = ['seeker', 'provider'];
        if (!in_array($request->role_name, $allowed_params, true)) {
            return $this->sendError('Role ' . $request->role_name . ' does not exist in database. Allowed roles are ' . implode(', ', $allowed_params), $validator->errors());
        }


        $users = User::whereHas('role', function ($query) use ($request) {
            $query->where('name', $request->role_name);
            $query->whereNotIn('id', [1, 2, 5]);
            $query->where('status', 1);
        })->get();

        if ($users == null) {
            return $this->sendError([], 'No user found');
        }

        return $this->sendResponse($users, 'Fetched user');
    }


    /**
     * @return JsonResponse
     */
    public function changeAvailabliiy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'available' => 'sometimes|numeric',
            'engaged' => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Data validation error', $validator->errors());
        }

        $user = AuthTrait::getUser();
        $data = [];
        if ($request->has('available')) {
            $data['available'] = $request->available;
        }
        if ($request->has('engaged')) {
            $data['engaged'] = $request->engaged;
        }

        try {
            $user->available = 1;
            DB::table('users')
                ->where('id', $user->id)
                ->update($data);
            return $this->sendResponse([], 'Availability and engaged status updated successfully');
        } catch (\Exception|QueryException $e) {

            return $this->sendError('Failed to update availability and engaged ' . $e->getMessage(), []);
        }


    }

    /**
     * Get All Provider by Role
     * @return JsonResponse
     */
    public function getSingleUser(Request $request, $id)
    {
        $user = User::with('role')->whereIn('role_id', [3])
            ->where('id', $id)
            ->first();

        if ($user == null) {
            return $this->sendError([], 'No user found');
        }

        return $this->sendResponse($user, 'Fetched user');

    }

    /**
     * @return JsonResponse
     */
    public function getUserRoles()
    {
        $roles = Role::orderBy('name', 'asc')
            ->whereNotIn('id', [1, 2, 5])
            ->select('id', 'name')
            ->get();

        if ($roles == null) {
            return $this->sendError([], 'No role found');
        }

        return $this->sendResponse($roles, 'Fetched roles');
    }

    /**
     * Profile Completion
     * @param Request $request
     * @return void
     */
    public function profileCompletion(Request $request)
    {
        $percentage = 0;

        $userProfileData = User\UserProfessionalData::where('user_id', AuthTrait::getUserId())->first();
        $userOtherInfoData = User\UserOtherInfo::where('user_id', AuthTrait::getUserId())->first();
        $userAcademicData = User\UserAcademicInfo::where('user_id', AuthTrait::getUserId())->first();
        $userServiceData = User\UserService::where('user_id', AuthTrait::getUserId())->first();
        $userLanguageProficiencyData = User\LanguageProficiency::where('user_id', AuthTrait::getUserId())->first();
        $userSpecialityData = User\UserSpeciality::where('user_id', AuthTrait::getUserId())->first();
        $userGalleryData = Gallery::where('user_id', AuthTrait::getUserId())->first();
        $userAddressData = User\UserAddress::where('user_id', AuthTrait::getUserId())->first();
        $userSavedAddressData = User\SavedAddress::where('user_id', AuthTrait::getUserId())->first();
        $user = User::where('id', AuthTrait::getUserId())->first();


        if ($userProfileData != null) {
            $percentage += 10;
        }

        if ($userOtherInfoData != null) {
            $percentage += 10;
        }


        if ($userAcademicData != null) {
            $percentage += 10;
        }

        if ($userServiceData != null) {
            $percentage += 10;
        }

        if ($userLanguageProficiencyData != null) {
            $percentage += 10;
        }

        if ($userSpecialityData != null) {
            $percentage += 10;
        }

        if ($userGalleryData != null) {
            $percentage += 10;
        }

        if ($userAddressData != null) {
            $percentage += 10;
        }

        if ($userSavedAddressData != null) {
            $percentage += 10;
        }

        if ($user->height != null) {
            $percentage += 2.5;
        }

        if ($user->wight != null) {
            $percentage += 2.5;
        }

        if ($user->otp_verified == 1) {
            $percentage += 2.5;
        }

        if ($user->documents_verified == 1) {
            $percentage += 2.5;
        }

        $data = ['percentage' => $percentage];
        if (!empty($data)) {
            return $this->sendResponse($data, 'Profile completion fetched');
        }

        return $this->sendError([], 'Failed to fetch');
    }


    /**
     * Academic Completion
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function academicCompletion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Data validation error', $validator->errors());
        }

        $validator->validated();

        $data = ['percentage' => 45];
        if (!empty($data)) {
            return $this->sendResponse($data, 'Academic completion fetched');
        }

        return $this->sendError([], 'Failed to fetch');
    }


    /**
     * Update User Current Location
     * @return JsonResponse
     * @throws ValidationException
     */
    public function updateLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lon' => 'sometimes|numeric',
            'lat' => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Data validation error', $validator->errors());
        }

        $data = $validator->validated();
        try {
            UserAddress::where([
                'user_id' => AuthTrait::getUserId(),
            ])->update(
                $data
            );
            return $this->sendResponse([], 'User location update successful');
        } catch (\Exception $e) {
            return $this->sendError('Failed to update user location ' . $e->getMessage());
        }
    }
}
