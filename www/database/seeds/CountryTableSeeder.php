<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use StartMeUp\Models\Country;

class CountryTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        DB::table(CreateCountriesTable::TABLE)->delete();

        $countries = [
            'BE' => 'Belgium',
            'DE' => 'Germany',
            'FR' => 'France',
            'GB' => 'United Kingdom',
            'LU' => 'Luxembourg',
            'NL' => 'Netherlands',
        ];

        foreach ($countries as $iso => $name) {
            Country::create([
                'name' => $name,
                'iso' => $iso,
            ]);
        }
    }
}
