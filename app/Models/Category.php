<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $category_name
 * @property int|null $parent_id
 * @property string|null $image
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Database\Factories\CategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $guarded = [];

    /**
     * @return BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_post');
    }

    /**
     * @param string $orderBy
     * @param string $order
     * @param int $status
     * @return array|mixed
     */
    public static function categoryTree(string $orderBy = 'categories.category_name', string $order = 'asc', int $status = 1)
    {
        $items = DB::table('categories')
            ->leftJoin('categories as parent', 'parent.id', '=', 'categories.parent_id')
            ->select('categories.*', 'parent.category_name as parent_category_name', 'categories.image as imgpath')
            ->where('categories.status', '=', $status)
            ->orderBy($orderBy, $order)
            ->get();

        return self::categoryItems($items);
    }

    /**
     * @param Collection $items
     * @return array|mixed
     */
    private static function categoryItems(Collection $items)
    {
        $childs = [];
        foreach ($items as $item) {
            $childs[$item->parent_id][] = $item;
        }

        foreach ($items as $item) {
            if (isset($childs[$item->id])) {
                $item->childs = $childs[$item->id];
            }
        }

        if (!empty($childs[0])) {
            $tree = $childs[0];
        } else {
            $tree = $childs;
        }

        return $tree;
    }


    /**
     * @return HasMany
     */
    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('childs');
    }
}
