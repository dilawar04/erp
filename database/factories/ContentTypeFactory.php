<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ContentType;
use Faker\Generator as Faker;

/*
 * ---------------------------------------------------------------------------------------------------------
 * Run: php artisan tinker
 * factory(App\ContentType::class, 50)->create();
 * ---------------------------------------------------------------------------------------------------------
 */

$factory->define(ContentType::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
                'identifier' => $faker->name,
                'meta_title' => $faker->name,
                'meta_description' => $faker->name,
                'meta_keywords' => $faker->name,
                'layout' => $faker->name,
                'fileds' => $faker->name,
            ];

});
