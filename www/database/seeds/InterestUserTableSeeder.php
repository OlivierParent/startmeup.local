<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use StartMeUp\Models\Interest;
use StartMeUp\User;

class InterestUserTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        DB::table(CreateInterestUserTable::TABLE)->delete();

        $interests = Interest::all();
        $users = User::all();

        foreach ($interests as $interest) {
            foreach ($users as $user) {
                $interest->users()->attach($user);
                $interest->save();
            }
        }
    }
}
