<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class ImageHelper
{
    private static $base_dir = 'public/uploads/';

    /**
     * image upload Method
     * @param Request $request
     * @param $image
     * @param $path
     * @param null $prefix
     * @param bool $thumb
     * @param int $width
     * @param int $height
     * @return array
     */
    public static function imageUpload(Request $request, $image, $path, $prefix = null, bool $thumb = false, int $width = 300, int $height = 300): array
    {
        $response = [];
        $image = $request->file($image);

        $fileName = $prefix . time() . '.' . $image->getClientOriginalExtension();
        $response['filename'] = $fileName;


        $img = Image::make($image->getRealPath());
        $img->stream();
        $fileName = self::$base_dir . $path . '/' . $fileName;
        Storage::disk('local')->put($fileName, $img);

        if ($thumb == true) {
            $fileNamethumb = $prefix . time() . '_thumb.' . $image->getClientOriginalExtension();
            $fileNamethumb = self::$base_dir . $path . '/' . $fileNamethumb;
            $thumbnail = $fileNamethumb;
            $imgThumb = Image::make($image->getRealPath());
            $imgThumb->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $imgThumb->stream();
            Storage::disk('local')->put($fileNamethumb, $imgThumb);
        } else {
            $thumbnail = '';
        }

        $response['file_path'] = str_replace('public/', 'storage/', $fileName);
        $response['thumb_path'] = str_replace('public/', 'storage/', $thumbnail);
        $response['base_dir'] = self::$base_dir;
        $response['save_path'] = str_replace('public/', 'storage/', self::$base_dir . $path);
        return $response;


    }
}
