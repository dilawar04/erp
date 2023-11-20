<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BlogPost;
use Faker\Generator as Faker;

/*
 * ---------------------------------------------------------------------------------------------------------
 * Run: php artisan tinker
 * factory(App\BlogPost::class, 50)->create();
 * ---------------------------------------------------------------------------------------------------------
 */

$factory->define(BlogPost::class, function (Faker $faker) {
    return [
        'author' => $faker->name,
                'datetime' => $faker->name,
                'title' => $faker->name,
                'slug' => $faker->slug,
                'content' => $faker->name,
                'status' => $faker->name,
                'comment_status' => $faker->name,
                'post_name' => $faker->name,
                'ordering' => $faker->randomDigit,
                'featured_image' => $faker->name,
            ];

});
