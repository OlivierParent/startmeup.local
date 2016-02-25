<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use StartMeUp\Models\Locality;
use StartMeUp\Models\Region;

class LocalityTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        DB::table(CreateLocalitiesTable::TABLE)->delete();

        $regions = [
            'BRU' => [
                'Brussels' => '1000',
            ],
            'VAN' => [
                'Antwerp' => '2000',
            ],
            'VBR' => [
                'Leuven' => '3000',
            ],
            'VLI' => [
                'Hasselt' => '3500',
            ],
            'VOV' => [
                'Afsnee' => '9051',
                'Ghent' => '9000',
                'Desteldonk' => '9042',
                'Drongen' => '9031',
                'Ledeberg' => '9050',
                'Mariakerke' => '9030',
                'Mendonk' => '9042',
                'Oostakker' => '9041',
                'Sint-Amandsberg' => '9040',
                'Sint-Denijs-Westrem' => '9051',
                'Sint-Kruis-Winkel' => '9042',
                'Wondelgem' => '9032',
                'Zwijnaarde' => '9052',
            ],
            'VWV' => [
                'Brugge' => '8000',
            ],
        ];

        foreach ($regions as $regionIso => $localities) {
            $region = Region::where('iso', $regionIso)->firstOrFail();
            foreach ($localities as $name => $postal_code) {
                $locality = new Locality();
                $locality->name = $name;
                $locality->postal_code = $postal_code;
                $locality->region()->associate($region);
                $locality->save();
            }
        }
    }
}
