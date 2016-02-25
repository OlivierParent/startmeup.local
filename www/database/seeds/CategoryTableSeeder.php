<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use StartMeUp\Models\Category;
use StartMeUp\User;

class CategoryTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        DB::table(CreateCategoriesTable::TABLE)->delete();

        $categories = Category::DEFAULT_CATEGORIES;

        $order = 0;
        foreach ($categories as $data) {
            $category = new Category($data);
            $category->order = $order++;
            $category->save();
        }

        $order = 0;
        $user = User::first();
        foreach ($categories as $data) {
            $category = new Category($data);
            $category->order = $order++;
            $category->user()->associate($user);
            $category->save();
        }
    }
}
