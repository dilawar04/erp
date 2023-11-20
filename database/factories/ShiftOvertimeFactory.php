<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ShiftOvertime;
use Faker\Generator as Faker;

/*
 * ---------------------------------------------------------------------------------------------------------
 * Run: php artisan tinker
 * factory(App\ShiftOvertime::class, 50)->create();
 * ---------------------------------------------------------------------------------------------------------
 */

$factory->define(ShiftOvertime::class, function (Faker $faker) {
    return [
        'shift_name' => $faker->name,
                'start_time' => $faker->name,
                'end_time' => $faker->name,
                'late_till' => $faker->name,
                'half_day_from' => $faker->name,
                'brake_name' => $faker->name,
                'b_from' => $faker->name,
                'b_till' => $faker->name,
                'days' => $faker->name,
            ];

});
