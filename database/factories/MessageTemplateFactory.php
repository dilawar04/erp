<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EmailTemplate;
use Faker\Generator as Faker;

/*
 * ---------------------------------------------------------------------------------------------------------
 * Run: php artisan tinker
 * factory(App\MessageTemplate::class, 50)->create();
 * ---------------------------------------------------------------------------------------------------------
 */

$factory->define(EmailTemplate::class, function (Faker $faker) {
    return [
        'lang_code' => $faker->nullable()->name,
                'title' => $faker->nullable()->name,
                'subject' => $faker->nullable()->name,
                'message' => $faker->nullable()->paragraph(3),
            ];

});
