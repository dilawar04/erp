<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Page;
use Faker\Generator as Faker;

/*
 * ---------------------------------------------------------------------------------------------------------
 * Run: php artisan tinker
 * factory(App\Page::class, 50)->create();
 * ---------------------------------------------------------------------------------------------------------
 */

$factory->define(Page::class, function (Faker $faker) {
    return [
        'url' => $faker->nullable()->unique()->url,
                'title' => $faker->nullable()->unique()->name,
                'parent_id' => $faker->nullable()->unique()->name,
                'show_title' => $faker->nullable()->unique()->name,
                'tagline' => $faker->nullable()->unique()->name,
                'content' => $faker->nullable()->unique()->name,
                'meta_title' => $faker->nullable()->unique()->name,
                'meta_keywords' => $faker->nullable()->unique()->name,
                'meta_description' => $faker->nullable()->unique()->name,
                'status' => $faker->nullable()->unique()->name,
                'thumbnail' => $faker->nullable()->unique()->image('assets/images/pages', 640, 480) ,
                'template' => $faker->nullable()->unique()->name,
                'ordering' => $faker->nullable()->unique()->randomDigit,
                'user_only' => $faker->nullable()->unique()->paragraph(3),
                'params' => $faker->nullable()->unique()->paragraph(3),
                'created_at' => $faker->nullable()->unique()->name,
                'updated_at' => $faker->nullable()->unique()->name,
            ];

});
