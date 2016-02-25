<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use StartMeUp\Models\Mood;
use StartMeUp\User;

class MoodTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        DB::table(CreateMoodsTable::TABLE)->delete();

        // Faker
        // -----
        $user = User::first();
        factory(Mood::class, self::$maxItems)
            ->make()
            ->each(function ($mood) use ($user) {
                $mood->user()->associate($user);
                $mood->save();
            });
    }
}
