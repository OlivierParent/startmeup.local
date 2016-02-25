<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use StartMeUp\Models\Settings;
use StartMeUp\User;

class SettingsTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        DB::table(CreateSettingsTable::TABLE)->delete();

        $users = User::all();
        foreach ($users as $user) {
            $settings = new Settings();
            $settings->user()->associate($user);
            $settings->save();
        }
    }
}
