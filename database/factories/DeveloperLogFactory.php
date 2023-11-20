<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DeveloperLog;
use Faker\Generator as Faker;

/*
 * ---------------------------------------------------------------------------------------------------------
 * Run: php artisan tinker
 * factory(App\DeveloperLog::class, 50)->create();
 * ---------------------------------------------------------------------------------------------------------
 */

$factory->define(DeveloperLog::class, function (Faker $faker) {
    return [
        'type' => $faker->nullable()->default('Pending')->name,
                'description' => $faker->nullable()->default('Pending')->paragraph(3),
                'table' => $faker->nullable()->default('Pending')->name,
                'table_id' => $faker->nullable()->default('Pending')->name,
                'user_id' => $faker->nullable()->default('Pending')->name,
                'user_ip' => $faker->nullable()->default('Pending')->name,
                'user_agent' => $faker->nullable()->default('Pending')->name,
                'current_URL' => $faker->nullable()->default('Pending')->name,
                'status' => $faker->nullable()->default('Pending')->name,
                'created_at' => $faker->nullable()->default('Pending')->name,
                'updated_at' => $faker->nullable()->default('Pending')->name,
            ];

});
