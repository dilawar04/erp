<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\StaticBlock;
use Faker\Generator as Faker;

/*
 * ---------------------------------------------------------------------------------------------------------
 * Run: php artisan tinker
 * factory(App\StaticBlock::class, 50)->create();
 * ---------------------------------------------------------------------------------------------------------
 */

$factory->define(StaticBlock::class, function (Faker $faker) {
    return [
        'title' => $faker->nullable()->default('Active')->name,
                'identifier' => $faker->nullable()->default('Active')->unique()->name,
                'content' => $faker->nullable()->default('Active')->unique()->paragraph(3),
                'status' => $faker->nullable()->default('Active')->unique()->name,
                'created_at' => $faker->nullable()->default('Active')->unique()->name,
                'updated_at' => $faker->nullable()->default('Active')->unique()->name,
            ];

});
