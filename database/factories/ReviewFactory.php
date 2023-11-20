<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Review;
use Faker\Generator as Faker;

/*
 * ---------------------------------------------------------------------------------------------------------
 * Run: php artisan tinker
 * factory(App\Review::class, 50)->create();
 * ---------------------------------------------------------------------------------------------------------
 */

$factory->define(Review::class, function (Faker $faker) {
    return [
        'user_id' => $faker->name,
                'ip' => $faker->name,
                'user_agent' => $faker->name,
                'rating' => $faker->name,
                'title' => $faker->name,
                'review' => $faker->paragraph(3),
                'nickname' => $faker->name,
            ];

});
