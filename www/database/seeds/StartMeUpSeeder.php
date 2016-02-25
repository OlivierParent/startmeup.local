<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

abstract class StartMeUpSeeder extends Seeder
{
    /**
     * @var string
     */
    public static $fakerLocale = 'nl_BE';

    /**
     * Maximum amount of items to seed.
     *
     * @var int
     */
    public static $maxItems = 10;

    /**
     * @var Faker
     */
    protected $faker = null;

    public function __construct()
    {
        $this->faker = Faker::create(self::$fakerLocale);
    }
}
