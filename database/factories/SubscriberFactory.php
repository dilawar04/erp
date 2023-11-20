<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Subscriber;
use Faker\Generator as Faker;

/*
 * ---------------------------------------------------------------------------------------------------------
 * Run: php artisan tinker
 * factory(App\Subscriber::class, 50)->create();
 * ---------------------------------------------------------------------------------------------------------
 */

$factory->define(Subscriber::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->email,
            ];

});
