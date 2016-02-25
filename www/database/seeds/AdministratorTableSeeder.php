<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use StartMeUp\Models\Administrator;

class AdministratorTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        DB::table(CreateAdministratorsTable::TABLE)->delete();

        Administrator::create([
            'email' => 'smu_admin@arteveldehs.be',
            'name' => 'smu_admin',
            'password' => Hash::make('smu_password'),
        ]);
    }
}
