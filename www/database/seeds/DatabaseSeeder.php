<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Illuminate\Database\Seeder;

//use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //        Model::unguard();

        $tables = [
            'Administrator',
            'Country',
            'Region',
            'Locality',
            'Address',
            'Company',
            'User',
            'Settings',
            'Interest',
            'InterestUser',
            'Location',
            'Category',
            'Goal',
            'TargetableUpdate',
            'Reward',
            'RewardUser',
            'Mood',
        ];

        $i = 0;
        foreach ($tables as $table) {
            $class = "${table}TableSeeder";
            $count = sprintf('%02d', ++$i);
            $this->command->getOutput()->writeln("<comment>Seed${count}:</comment> ${class}...");
            $this->call($class);
        }
    }
}
