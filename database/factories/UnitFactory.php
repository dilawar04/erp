<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Unit;
use Faker\Generator as Faker;

/*
 * ---------------------------------------------------------------------------------------------------------
 * Run: php artisan tinker
 * factory(App\Unit::class, 50)->create();
 * ---------------------------------------------------------------------------------------------------------
 */

$factory->define(Unit::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'code' => $faker->name,
        'user_id' => $faker->name,
    ];

});
