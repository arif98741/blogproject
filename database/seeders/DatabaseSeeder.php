<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();
        \App\Models\Category::factory(15)->create();
        \App\Models\Post::factory(20)->create();
        \App\Models\Tag::factory(20)->create();
        \App\Models\PostTag::factory(5)->create();
        \App\Models\CategoryPost::factory(5)->create();

      /*  DB::table('categories')
            ->insert([
                [
                    'category_name' => 'Electronics',
                ],
                [
                    'category_name' => 'Home Decor',
                ],
                [
                    'category_name' => 'Internet',
                ],
                [
                    'category_name' => 'Programming',
                ],
                [
                    'category_name' => 'Furniture',
                ],
            ]);*/

    }
}
