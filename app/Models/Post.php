<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'feature_image',
        'thumbnail_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
    ];

    /**
     * @return BelongsToMany
     */
    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
