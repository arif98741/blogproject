<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
}
