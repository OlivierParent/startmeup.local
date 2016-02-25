<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use StartMeUp\Models\Country;
use StartMeUp\Models\Region;

class RegionTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        DB::table(CreateRegionsTable::TABLE)->delete();

        $countries = [
            'BE' => [
                'VAN' => 'Antwerp',
                'BRU' => 'Brussels-Captital Region',
                'VLI' => 'Limburg',
                'VOV' => 'East Flanders',
                'VWV' => 'West Flanders',
                'VBR' => 'Flemish Brabant',
            ],
        ];

        foreach ($countries as $countryIso => $regions) {
            $country = Country::where('iso', $countryIso)->firstOrFail();

            foreach ($regions as $iso => $name) {
                $region = new Region();
                $region->name = $name;
                $region->iso = $iso;
                $region->country()->associate($country);
                $region->save();
            }
        }
    }
}
