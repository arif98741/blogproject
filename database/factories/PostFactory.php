<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => ucfirst($this->faker->text(100)),
            'user_id' => User::all()->random(),
            'slug' => ucfirst($this->faker->text(100)),
            'description' => ucfirst($this->faker->text(100)),
            'feature_image' => null,
            'thumbnail_image' => null,
            'is_feature' => $this->faker->randomElement([0, 1]),
            'is_home' => $this->faker->randomElement([0, 1]),
            'created_by' => User::all()->random(),
            'updated_by' => User::all()->random(),
            'meta_title' => ucfirst($this->faker->text(50)),
            'meta_description' => ucfirst($this->faker->text(100)),
            'meta_keywords' => ucfirst($this->faker->text(40)),
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}
