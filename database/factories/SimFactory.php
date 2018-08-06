<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Sim::class, function (Faker $faker) {
    return [
        'sim_number' => rand(98729237491111111, 98729237499999999),
        'value' => rand(20,60),
        'activation_date' => '12/17/2017',
        'mobile_number' => rand(6191111111,6199999999),
        'report_type_id' => rand(1,7), // report type id will tell you the name and carrier
        'upload_date' => '6_2018',
        //'carrier' => 'H2O Wireless',
        //'email' => $faker->unique()->safeEmail,
        //'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        //'remember_token' => str_random(10),
    ];
});
