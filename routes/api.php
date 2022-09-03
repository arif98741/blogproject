<?php
/*
 *
 * =================================================================
 * Project: decathlon_pro
 * Last Modified: 8/16/22, 6:47 PM
 * file: C:/wamp64/www/decathlon_pro/routes/api.php
 * class: api.php
 * Copyright (c) 2022
 * created by Ariful Islam
 * All Rights Preserved "By Mediasoft Data Systems Limited"
 * If you have any query then knock me at
 * arif98741@gmail.com
 * See my profile @ https://github.com/arif98741
 * ========================================================================
 *
 */

use App\Http\Controllers\Api\V1\AppSliderController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ExpertiseController;
use App\Http\Controllers\Api\V1\SpecialityController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'v1',
        'namespace' => 'Api\V1',

    ], static function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('/register/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/register/resend-otp', [AuthController::class, 'resendOtp']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/change-password-by-otp', [AuthController::class, 'changePasswordByOtp']);

    Route::middleware('auth:api')->group(function () {

        Route::group(['prefix' => 'user', 'namespace' => 'User'], static function () {

            Route::group(['prefix' => 'profile'], static function () {
                Route::post('/update', 'UserProfileController@updateProfile');
                Route::get('/', 'UserProfileController@profile');
            });
        });

    });
});

