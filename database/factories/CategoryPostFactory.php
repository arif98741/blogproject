<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::all()->random()->unique,
            'post_id' => Post::all()->random()->unique,
        ];
    }
}
