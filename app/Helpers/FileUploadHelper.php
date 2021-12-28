<?php

namespace App\Helpers;


class FileUploadHelper
{

    /**
     * @var string
     */
    private static $base_dir = 'public/uploads/'; //uploads folder located inside storage/app/public/uploads

    /**
     * image upload Method
     * @param $request
     * @param $path
     * @param string $prefix
     * @param string $uniqueIndentifier
     * @return array|mixed|string|string[]
     */
    public static function fileUpload($request, $path, string $prefix = '', string $uniqueIndentifier = '')
    {
        $file = $request->file('file')->getClientOriginalName();
        $fileName = $prefix . '_' . $uniqueIndentifier . '_' . time() . '-' . $file;
        $uploadPath = $request->file('file')->storeAs(self::$base_dir . $path, $fileName);
        return str_replace('public/', 'storage/', $uploadPath);
    }
}
