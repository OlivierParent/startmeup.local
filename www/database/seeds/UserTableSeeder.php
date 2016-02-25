<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use StartMeUp\User;

class UserTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        DB::table(CreateUsersTable::TABLE)->delete();

        // Create a test user
        User::create([
            'email' => 'smu_user@arteveldehs.be',
            'name' => 'smu_user',
            'password' => Hash::make('smu_password'),
            'given_name' => 'StartMeUp',
            'family_name' => 'User',
        ]);

        // Faker
        // -----
        factory(User::class, self::$maxItems)->create();
    }
}
