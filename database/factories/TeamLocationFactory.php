<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TeamLocation;
use Faker\Generator as Faker;

/*
 * ---------------------------------------------------------------------------------------------------------
 * Run: php artisan tinker
 * factory(App\TeamLocation::class, 50)->create();
 * ---------------------------------------------------------------------------------------------------------
 */

$factory->define(TeamLocation::class, function (Faker $faker) {
    return [
        'location' => $faker->name,
                'ordering' => $faker->randomDigit,
            ];

});
