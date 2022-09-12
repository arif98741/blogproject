<?php
/*
 *
 * =================================================================
 * Project: decathlon_pro
 * Last Modified: 8/16/22, 6:31 PM
 * file: C:/wamp64/www/decathlon_pro/app/Http/Controllers/Api/V1/AuthController.php
 * class: AuthController.php
 * Copyright (c) 2022
 * created by Ariful Islam
 * All Rights Preserved "By Mediasoft Data Systems Limited"
 * If you have any query then knock me at
 * arif98741@gmail.com
 * See my profile @ https://github.com/arif98741
 * ========================================================================
 *
 */

namespace App\Http\Controllers\Api\V1;

use App\Facades\AppFacade;
use App\Helpers\DataHelper;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Xenon\LaravelBDSms\Facades\SMS;

class AuthController extends BaseController
{
    /**
     * User Registration
     * @group Authentication
     * @header X-api-version
     * For registration, you should pass data and other parameters
     * @param Request $request
     * @return JsonResponse|void
     * @throws Exception
     * @unauthenticated
     * @version   v1.0.1
     */
    public function register(Request $request)
    {
        $preRegistered = User::where([
            'phone' => $request->phone,
        ])->first();

        if ($preRegistered != null && $preRegistered->otp_verified == 0) {

            $otpData = Otp::where([
                'purpose' => 'register',
                'purpose_id' => $preRegistered->id
            ])->select('sent', 'code', 'expiration')
                ->orderBy('id', 'desc')
                ->first();

            try {
                //write here
                $sentTime = $otpData->sent;

            } catch (Exception $e) {
                return $this->sendError('Unexpected error', ['error' => 'Unexpected error']);
            }


            $nextSentTime = Carbon::createFromDate($sentTime)
                ->addMinute(1)
                ->format('Y-m-d H:i:s');
            if (Carbon::now() < $nextSentTime) {

                return $this->sendError('You can request otp after 1 minute', ['error' => 'Flood api request']);
            }

            $otp = rand(111111, 999999);

            $message = "Your code is $otp $request->signature_otp. Takecare";
            // $response = AppFacade::sendOtp($preRegistered->phone, $message);

            $phone = $preRegistered->phone;
            SMS::shoot($phone, $message);
            $data = [
                'sent' => Carbon::now(),
                'code' => $otp,
                'purpose' => 'register',
                'expiration' => Carbon::now()
                    ->addMinute(10)
                    ->format('Y-m-d H:i:s'),
                'purpose_id' => $preRegistered->id
            ];
            AppFacade::saveOtp($data);

            User::where('id', $preRegistered->id)
                ->update(['password' => Hash::make($request->password)]);

            return $this->sendResponse([], 'Phone number already exist without verifying otp; Verify your account and login with your new password ');
        }

        if ($preRegistered != null && $preRegistered->otp_verified == 1) {
            return $this->sendError('Phone number already registered');
        }

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|min:3|max:100',
            'gender' => 'required',
            'phone' => 'required',
            'role' => 'required|int',
            'password' => 'required',
        ]);


        if ($validator->fails()) {
            return $this->sendError('Data validation error', $validator->errors());
        }

        if (!DataHelper::checkNumberValidity($request->phone)) {
            return $this->sendError('Invalid phone number', [
                'phone' => [
                    'provided phone number is invalid'
                ]
            ]);
        }


        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['user_slug'] = Str::slug($input['full_name']) . random_int(11111, 99999);
        $input['role_id'] = $request->role;


        if ($request->role === 4) {

            $validator = Validator::make($request->all(), [
                'expertise_id' => 'sometimes|integer',
                'speciality_id' => 'sometimes|integer',
                'phone' => 'required',
                'signature_otp' => 'sometimes',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Data validation error', $validator->errors());
            }

            $input['email'] = $request->email;
            $input['expertise_id'] = $request->expertise_id;
            $input['speciality_id'] = $request->speciality_id;
            $input['signature_otp'] = $request->signature_otp;
            $input['status'] = 1;

        }


        $user = User::create($input);
        //  $success['token'] = $user->createToken('MyApp')->accessToken; //this will be used on once
        if ($user) {

            $userData = User::find($user->id);

            $otp = random_int(111111, 999999);
            $message = "Your code is $otp $request->signature_otp. Takecare";
            $phone = $userData->phone;
            SMS::shoot($phone, $message);

            $data = [
                'sent' => Carbon::now(),
                'code' => $otp,
                'purpose' => 'register',
                'expiration' => Carbon::now()
                    ->addMinute(10)
                    ->format('Y-m-d H:i:s'),
                'purpose_id' => $userData->id
            ];

            AppFacade::saveOtp($data);
            $success['user'] = $userData;
            $success['otp'] = $otp;
            return $this->sendResponse($success, 'User register successful. Please check otp');

        }

    }

    /**
     * Login api
     * @group Authentication
     * @param Request $request
     * @return JsonResponse
     * @response  {'hello'}
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required',
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Data validation error', $validator->errors());
        }

        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password, 'role_id' => $request->role_id,/* 'otp_verified' => 1*/])) {

            $user = Auth::user();
            if ($user->otp_verified == 0) {
                Auth::logout();
                return $this->sendError('Your phone number is not verified! Please contact to your office.', ['error' => '']);
            }

            if ($user->status == 0) {
                Auth::logout();
                return $this->sendError('Your account is Inactive! Please contact to your office.', ['error' => '']);
            }


            if ($user->role_id == 3) {
                $tokenName = 'ProviderToken';
            } else if ($user->role_id == 4) {
                $tokenName = 'UserToken';
            } else {
                $tokenName = 'TakeCareApp';
            }

            if ($request->token != $user->fcm_token) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'fcm_token' => $request->token
                    ]);
            }

            $user = Auth::user();
            $success['user'] = $user;
            $success['token'] = $user->createToken($tokenName)->accessToken;

            return $this->sendResponse($success, 'User login successfully.');
        }

        return $this->sendError('Phone or password not matched', ['error' => 'Username or password not matched']);
    }

    /**
     * Send Otp Again
     * @group Authentication
     * @param Request $request
     * @return JsonResponse|void
     */
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Data validation error', $validator->errors());
        }

        $userData = User::where([
            'otp_verified' => 0,
            'phone' => $request->phone,
        ])->select('id', 'phone', 'otp_verified')->first();

        if ($userData == null) {
            return $this->sendError('Already verified or not exist', ['error' => '']);
        }


        $otpData = Otp::where([
            'purpose' => 'register',
            'purpose_id' => $userData->id,

        ])->select('sent', 'code', 'expiration')
            ->orderBy('id', 'desc')
            ->first();

        $sentTime = $otpData->sent;
        $nextSentTime = Carbon::createFromDate($sentTime)
            ->addMinute(1)
            ->format('Y-m-d H:i:s');
        if (Carbon::now() < $nextSentTime) {

            return $this->sendError('You can request otp after 1 minute', ['error' => 'Flood api request']);
        }


        $otp = rand(111111, 999999);
        $message = "Your code is $otp $userData->signature_otp. Takecare";
        $response = SMS::shoot($userData->phone, $message);

        if ($response == true) {
            $data = [
                'sent' => Carbon::now(),
                'code' => $otp,
                'purpose' => 'register',
                'expiration' => Carbon::now()
                    ->addMinute(10)
                    ->format('Y-m-d H:i:s'),
                'purpose_id' => $userData->id
            ];

            Otp::where('purpose', 'register')
                ->where('purpose_id', $userData->id)
                ->delete();

            AppFacade::saveOtp($data);
            $success['user'] = $userData;
            return $this->sendResponse($success, 'Register otp resent');
        }

    }

    /**
     * verify otp for user
     * @group Authentication
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'otp' => 'required|int|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Data validation error', $validator->errors());
        }

        $userData = User::where([
            'phone' => $request->phone,
        ])->select('id')->first();

        if ($userData == null) {
            return $this->sendError('Phone number not exist');
        }

        $otpData = Otp::where([
            'purpose' => 'register',
            'purpose_id' => $userData->id,
            'code' => $request->otp,
            'status' => 0,
        ])->orderBy('id', 'desc')->first();

        if ($otpData == null) {
            return $this->sendError('Otp is invalid');
        }

        User::where('id', $userData->id)
            ->update(['otp_verified' => 1]);
        Otp::where('id', $otpData->id)
            ->update(['status' => 1]);
        return $this->sendResponse([], 'Otp verification successful. You can login now');

    }

    /**
     * Forgot Password
     * @param Request $request
     * @return JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Data validation error', $validator->errors());
        }

        $userData = User::where([
            'phone' => $request->phone,
        ])->select('id', 'phone', 'otp_verified', 'signature_otp')->first();

        if ($userData == null) {
            return $this->sendError('Phone number not exist', ['error' => '']);
        }


        $otp = rand(111111, 999999);
        $message = "Your code is $otp $request->signature_otp. Takecare";
        SMS::shoot($userData->phone, $message);

        $data = [
            'sent' => Carbon::now(),
            'code' => $otp,
            'purpose' => 'forgot-password',
            'expiration' => Carbon::now()
                ->addMinute(10)
                ->format('Y-m-d H:i:s'),
            'purpose_id' => $userData->id
        ];

        DB::table('otps')->where([
            'purpose_id' => $userData->id,
            'purpose' => 'forgot-password',
        ])->delete();

        AppFacade::saveOtp($data);
        return $this->sendResponse([], 'Forgot password otp sent');
    }

    /**
     * verify otp for user
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function changePasswordByOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'otp' => 'required|int|min:6',
            'new_password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Data validation error', $validator->errors());
        }

        $userData = User::where([
            'phone' => $request->phone,
        ])->select('id')->first();

        if ($userData == null) {
            return $this->sendError('Phone number not exist');
        }

        $otpData = DB::table('otps')->where([
            'purpose' => 'forgot-password',
            'purpose_id' => $userData->id,
            'code' => $request->otp,
            'status' => 0,
        ])->orderBy('id', 'desc')
            ->first();

        if ($otpData == null) {
            return $this->sendError('Otp is invalid');
        }

        DB::table('otps')->where('id', $otpData->id)
            ->update(['status' => 1]);
        User::where('id', $userData->id)
            ->update(['password' => Hash::make($request->new_password)]);
        return $this->sendResponse([], 'Password successfully changed');

    }

}
