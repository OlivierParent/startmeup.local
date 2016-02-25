<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use StartMeUp\Models\Address;
use StartMeUp\Models\Company;

class CompanyTableSeeder extends StartMeUpSeeder
{
    public function run()
    {
        DB::table(CreateCompaniesTable::TABLE)->delete();

        $address = Address::where('street', 'Industrieweg 232')->firstOrFail();

        $company = new Company();
        $company->name = 'Arteveldehogeschool';
        $company->description = 'Mediacampus Mariakerke';
        $company->address()->associate($address);
        $company->save();

        // Faker
        // -----
        $faker = $this->faker;
        factory(Company::class, self::$maxItems)
            ->make()
            ->each(function ($company) use ($faker) {
                $address = Address::find($faker->unique()->numberBetween(1, self::$maxItems));
                $company->address()->associate($address);
                $company->save();
            });
    }
}
