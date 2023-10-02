<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\Customer;

class helper
{
    /**
     * Get site name by site id 
     * @param site_id
     * @return string
     */
    static function getSite($site_id): string
    {
        return Customer::find($site_id)->first()->name;
    }

    /**
     * Get category_id by category name 
     * @param category_name
     * @return int
     */
    static function getCategoryId($category_name): int
    {
        $category = Category::where('category_name', $category_name)->first();
        if (is_null($category)) {
            $category = Category::create([
                'category_name' =>  $category_name
            ]);
        }

        return $category->id;
    }
}
