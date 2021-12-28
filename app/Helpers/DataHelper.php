<?php
/*
 * Copyright (c) 2021.
 * This file is originally created and maintained by Ariful Islam.
 * You are not allowed to modify any parts of this code or copy or even redistribute
 * full or small portion to anywhere. If you have any question
 * fee free to ask me at arif98741@gmail.com.
 * Ariful Islam
 * Software Engineer
 * https://github.com/arif98741
 */

namespace App\Helpers;

class DataHelper
{
    /**
     * Check Number Format if it is valid or not
     * @param $number
     * @return false|mixed
     */
    public static function checkNumberValidity($number)
    {
        $validCheckPattern = "/^(?:\+88|01)?(?:\d{11}|\d{13})$/";
        if (preg_match($validCheckPattern, $number)) {
            if (preg_match('/^(?:01)\d+$/', $number)) {
                return $number;
            }

        }

        return false;
    }
}
