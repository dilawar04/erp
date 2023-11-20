<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BlogCategory;
use Faker\Generator as Faker;

/*
 * ---------------------------------------------------------------------------------------------------------
 * Run: php artisan tinker
 * factory(App\BlogCategory::class, 50)->create();
 * ---------------------------------------------------------------------------------------------------------
 */

$factory->define(BlogCategory::class, function (Faker $faker) {
    return [
        'category' => $faker->name,
                'parent_id' => $faker->name,
                'slug' => $faker->slug,
            ];

});
