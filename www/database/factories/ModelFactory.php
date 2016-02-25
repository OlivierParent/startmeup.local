<?php

/**
 * @author    Olivier Parent
 * @copyright Copyright © 2014-2015 Artevelde University College Ghent
 * @license   Apache License, Version 2.0
 */
use Carbon\Carbon;
use Faker\Provider\nl_BE as Faker;
use StartMeUp\Models\Address;
use StartMeUp\Models\Company;
use StartMeUp\Models\Country;
use StartMeUp\Models\Interest;
use StartMeUp\Models\Locality;
use StartMeUp\Models\Location;
use StartMeUp\Models\Mood;
use StartMeUp\Models\Region;
use StartMeUp\Models\Reward;
use StartMeUp\Models\TargetCheckbox;
use StartMeUp\Models\TargetDuration;
use StartMeUp\Models\TargetRecurringCheckbox;
use StartMeUp\Models\UpdateDuration;
use StartMeUp\Models\UpdateRecurringCheckbox;
use StartMeUp\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

//$factory->define(Model::class, function ($faker) {
//    $faker->addProvider(new Faker\Address($faker));
//    $faker->addProvider(new Faker\Company($faker));
//    $faker->addProvider(new Faker\Internet($faker));
//    $faker->addProvider(new Faker\Person($faker));
//    $faker->addProvider(new Faker\PhoneNumber($faker));
//
//    return [
//        '' => $faker->word(),
//    ];
//});

$factory->define(Address::class, function ($faker) {
    $faker->addProvider(new Faker\Address($faker));

    return [
        'street' => $faker->streetName.' '.$faker->numberBetween(1, 150),
    ];
});

$factory->define(Company::class, function ($faker) {
    $faker->addProvider(new Faker\Company($faker));

    return [
        'name' => $faker->unique()->company(),
        'description' => $faker->catchPhrase(),
    ];
});

$factory->define(Country::class, function ($faker) {
    return [
        'name' => ucwords($faker->unique()->word()),
    ];
});

$factory->define(Interest::class, function ($faker) {
    return [
        'name' => $faker->unique()->word(),
    ];
});

$factory->define(Locality::class, function ($faker) {
    return [
        'postal_code' => $faker->postcode(),
        'name' => ucwords($faker->unique()->word()),
    ];
});

$factory->define(Location::class, function ($faker) {
    return [
        'title' => $faker->word(),
        'subtitle' => $faker->sentence($words = 3),
        'description' => $faker->paragraph($sentences = 3),
        'type' => $faker->randomElement(Location::TYPES),
        'latitude' => $faker->randomFloat(8, 50.80, 51.20),
        'longitude' => $faker->randomFloat(8,  3.52,  3.92),
    ];
});

$factory->define(Mood::class, function ($faker) {
    return [
        'feeling' => $faker->randomElement(Mood::FEELINGS),
    ];
});

$factory->define(Region::class, function ($faker) {
    return [
        'name' => ucwords($faker->unique()->word()),
    ];
});

$factory->define(Reward::class, function ($faker) {
    return [
        'name' => ucwords($faker->sentence($words = 3)),
        'description' => $faker->paragraph($sentences = 3),
    ];
});

$factory->define(TargetCheckbox::class, function ($faker) {
    $deadline = Carbon::now()->addWeek($faker->numberBetween($min = 1, $max = 10));

    return [
        'deadline_date' => $deadline->toDateString(),
        'deadline_time' => $deadline->toTimeString(),
        'deadline_reminder' => $faker->boolean(75),
    ];
});

$factory->define(TargetDuration::class, function ($faker) {
    return [
        'time_estimated' => $faker->numberBetween($min = 1, $max = 96),
        'time_increment' => $faker->randomElement(TargetDuration::TIME_INCREMENTS),
    ];
});

$factory->define(TargetRecurringCheckbox::class, function ($faker) {
    $deadline = Carbon::now()->addWeek($faker->numberBetween($min = 1, $max = 10));
    $repeatDeadline = $faker->randomElement(TargetRecurringCheckbox::REPEATS);
    $repeatUntilAt = ($repeatDeadline) ? Carbon::now()->addWeek($faker->numberBetween($min = 1, $max = 10)) : null;

    return [
        'deadline_date' => $deadline->toDateString(),
        'deadline_time' => $deadline->toTimeString(),
        'deadline_reminder' => $faker->boolean(75),
        'repeat_deadline' => $repeatDeadline,
        'repeat_until_date' => $repeatUntilAt ? $repeatUntilAt->toDateString() : null,
        'repeat_until_time' => $repeatUntilAt ? $repeatUntilAt->toDateString() : null,
    ];
});

$factory->define(UpdateDuration::class, function ($faker) {
    return [
        'time_incrementation' => $faker->numberBetween($min = 1, $max = 96),
    ];
});

$factory->define(UpdateRecurringCheckbox::class, function ($faker) {
    return [
        'achieved_at' => Carbon::now(),
    ];
});

$factory->define(User::class, function ($faker) {
    $faker->addProvider(new Faker\Internet($faker));
    $faker->addProvider(new Faker\Person($faker));
    $faker->addProvider(new Faker\PhoneNumber($faker));

    return [
        'name' => $faker->userName,
        'email' => $faker->email,
        'password' => Hash::make($faker->word()),
        'remember_token' => str_random(10),

        'given_name' => $faker->firstName,
        'family_name' => $faker->lastName,
        'gender' => $faker->randomElement(User::GENDERS),
        'birthday' => $faker->date($format = 'Y-m-d', $max = '-18 years'),
        'biography' => $faker->paragraph($sentences = 3),
        'mobile' => $faker->phoneNumber,
    ];
});
