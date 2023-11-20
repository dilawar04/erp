<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Banner;
use Faker\Generator as Faker;

/*
 * ---------------------------------------------------------------------------------------------------------
 * Run: php artisan tinker
 * factory(App\Banner::class, 50)->create();
 * ---------------------------------------------------------------------------------------------------------
 */

$factory->define(Banner::class, function (Faker $faker) {
    return [
        'image' => $faker->nullable()->image('assets/images/banners', 640, 480),
        'title' => $faker->nullable()->name,
        'type' => $faker->nullable()->name,
        'rel_id' => $faker->nullable()->name,
        'link' => $faker->nullable()->name,
        'ordering' => $faker->nullable()->randomDigit,
        'created_at' => $faker->nullable()->name,
        'updated_at' => $faker->nullable()->name,
        'status' => $faker->nullable()->name,
        'description' => $faker->nullable()->paragraph(3),
    ];

});
