<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_name'
    ];

    /**
     * @return SliderType[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAll()
    {
        return self::all();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public static function getSingleType(int $id)
    {
        return self::find($id);
    }
}
