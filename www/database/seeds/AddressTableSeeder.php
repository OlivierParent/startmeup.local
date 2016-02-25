<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use StartMeUp\Models\Address;
use StartMeUp\Models\Locality;

class AddressTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        DB::table(CreateAddressesTable::TABLE)->delete();

        $locality = Locality::where('postal_code', '9030')->where('name', 'Mariakerke')->firstOrFail();

        $address = new Address();
        $address->street = 'Industrieweg 232';
        $address->locality()->associate($locality);
        $address->save();

        // Faker
        // -----
        $faker = $this->faker;
        $localities = Locality::all();
        factory(Address::class, self::$maxItems)
            ->make()
            ->each(function ($address) use ($faker, $localities) {
                $locality_id = $faker->numberBetween(0, $localities->count() - 1);
                $locality = $localities->get($locality_id);
                $address->locality()->associate($locality);
                $address->save();
            });
    }
}
