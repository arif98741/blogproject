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
        \App\Models\Tag::factory(10)->create();

        DB::table('categories')
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
            ]);

    }
}
