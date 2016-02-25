<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use StartMeUp\Models\Reward;

class RewardTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        DB::table(CreateRewardsTable::TABLE)->delete();

        // Faker
        // -----
        factory(Reward::class, self::$maxItems)->create();
    }
}
