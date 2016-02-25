<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use StartMeUp\Models\Address;
use StartMeUp\Models\Location;
use StartMeUp\User;

class LocationTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        DB::table(CreateLocationsTable::TABLE)->delete();

        $address = Address::where('street', 'Industrieweg 232')->firstOrFail();
        $user = User::first();

        $location = new Location([
            'title' => 'Arteveldehogeschool',
            'subtitle' => 'Mediacampus Mariakerke',
            'description' => 'Bachelor in de grafische en digitale media',
            'type' => Location::TYPE_EDU,
            'latitude' => 51.086771,
            'longitude' => 3.670078,
        ]);
        $location->address()->associate($address);
        $location->user()->associate($user);
        $location->save();

        // Faker
        // -----
        $faker = $this->faker;
        factory(Location::class, self::$maxItems)
            ->make()
            ->each(function ($location) use ($faker) {
                $address = Address::find($faker->numberBetween(1, self::$maxItems));
                $location->address()->associate($address);
                $location->save();
            });
    }
}
