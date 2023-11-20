<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Menu;
use Faker\Generator as Faker;

/*
 * ---------------------------------------------------------------------------------------------------------
 * Run: php artisan tinker
 * factory(App\Menu::class, 50)->create();
 * ---------------------------------------------------------------------------------------------------------
 */

$factory->define(Menu::class, function (Faker $faker) {
    return [
        'parent_id' => $faker->randomDigit,
        'menu_title' => $faker->name,
        'menu_link' => $faker->name,
        'menu_type' => $faker->name,
        'menu_type_id' => $faker->name,
        'ordering' => $faker->randomDigit,
        'params' => $faker->paragraph(3),
        'status' => $faker->name,
    ];

});
