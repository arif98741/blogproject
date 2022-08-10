<?php

namespace App\AppTrait;

use App\Models\Core\Image;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as ImageIntervention;

trait FileTrait
{
    //table images
    /**
     * @var string
     */
    private static $base_dir = 'app/public/'; //uploads folder located inside storage/app/public/uploads

    /**
     * image upload Method
     * @param $request
     * @param string $fileName
     * @param string $path
     * @param string $prefix
     * @param string $uniqueIdentifier
     * @return string
     */
    public function imageUpload($request, string $fileName, string $path, string $prefix = 'img_', string $uniqueIdentifier = '')
    {
        $file = $request->file($fileName);
        $extension = $file->getClientOriginalExtension();
        $fileName = $this->generateRandomString(25);
        $name = $prefix . $uniqueIdentifier . '_' . time() . '-' . $fileName . '.' . $extension;
        $mainPath = 'file/images/media/' . $path . '/';
        $uploadDir = self::$base_dir . $mainPath;


        if (!File::exists($uploadDir)) {
            File::makeDirectory(storage_path($uploadDir), 0777, true, true);
        }

        $destinationPath = storage_path($uploadDir);
        $imageObject = ImageIntervention::make($file);
        $imageObject->save($destinationPath . $name);
        $size = getimagesize($file);
        [$width, $height, $type, $attr] = $size;

        $uploadedString = 'storage/' . $mainPath . $name;


        DB::beginTransaction();

        try {

            DB::table('images')->insert([[
                'image_type' => '1',
                'height' => $height,
                'width' => $width,
                'path' => $uploadedString,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]]);

            DB::commit();
            $image = DB::table('images')->orderBy('id', 'desc')->first();

            return $image->id;

        } catch (Exception $e) {

            DB::rollback();
            return null;
        }


    }


    /**
     * image upload Method
     * @param $request
     * @param $path
     * @param string $prefix
     * @param string $uniqueIndentifier
     * @return array
     */
    public function fileUploadMultiples($request, $path, string $prefix = '', string $uniqueIndentifier = ''): array
    {
        $uploadedFiles = [];
        foreach ($request->file as $key => $doc) {

            $media_ext = $doc->getClientOriginalName();
            $mFiles = $prefix . '_' . $uniqueIndentifier . '_' . time() . '-' . $media_ext;
            $uploadPath = $request->file('file')[$key]->storeAs(self::$base_dir . $path, $mFiles);
            $uploadPath = str_replace('public/', 'storage/', $uploadPath);
            $uploadedFiles[] = $uploadPath;
        }
        return $uploadedFiles;
    }

    /**
     * @param $request
     * @param string $fileName
     * @param string $path
     * @param $image_id
     * @param string $prefix
     * @param string $uniqueIdentifier
     * @return mixed|null
     * @throws Exception
     */
    public function imageUpdate($request, string $fileName, string $path, $image_id, string $prefix = 'img_', string $uniqueIdentifier = '')
    {

        $file = $request->file($fileName);
        $extension = $file->getClientOriginalExtension();
        $fileName = $this->generateRandomString(25);
        $name = $prefix . $uniqueIdentifier . '_' . time() . '-' . $fileName . '.' . $extension;
        $mainPath = 'file/images/media/' . $path . '/';
        $uploadDir = self::$base_dir . $mainPath;

        $existImageObject = Image::where('id', $image_id)->first();

        if (($existImageObject !== null) && File::exists($existImageObject->path)) {

            File::delete($existImageObject->path);
        }


        if (!File::exists($uploadDir)) {
            File::makeDirectory(storage_path($uploadDir), 0777, true, true);
        }

        $destinationPath = storage_path($uploadDir);
        $imageObject = ImageIntervention::make($file);
        $imageObject->save($destinationPath . $name);
        $size = getimagesize($file);
        [$width, $height, $type, $attr] = $size;

        $uploadedString = 'storage/' . $mainPath . $name;
        if ($image_id === null) {

            DB::beginTransaction();

            DB::table('images')->insert([[
                'image_type' => '1',
                'height' => $height,
                'width' => $width,
                'path' => $uploadedString,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]]);

            $image = DB::table('images')->orderBy('id', 'desc')->first();
            DB::commit();
            return $image->id;
        } else {
            DB::table('images')
                ->where('id', $image_id)
                ->update([
                    'image_type' => '1',
                    'height' => $height,
                    'width' => $width,
                    'path' => $uploadedString,
                    'updated_at' => Carbon::now(),
                ]);
            return $image_id;
        }


    }

    /**
     * @param $length
     * @return string
     */
    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return strtolower($randomString);
    }
}
