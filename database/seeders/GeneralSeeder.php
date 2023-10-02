<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'category_name' =>  'category one'
            ],
            [
                'category_name' =>  'category two'
            ],
            [
                'category_name' =>  'category three'
            ],
            [
                'category_name' =>  'category four'
            ],
            [
                'category_name' =>  'category five'
            ],
        ];

        Category::insert($categories);
    }
}
