<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Enquiry;
use Faker\Generator as Faker;

/*
 * ---------------------------------------------------------------------------------------------------------
 * Run: php artisan tinker
 * factory(App\Enquiry::class, 50)->create();
 * ---------------------------------------------------------------------------------------------------------
 */

$factory->define(Enquiry::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
                'email' => $faker->email,
                'message' => $faker->paragraph(3),
            ];

});
