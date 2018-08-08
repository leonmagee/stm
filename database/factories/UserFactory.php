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

$factory->define(App\User::class, function (Faker $faker) {
	$role_array = array('agent','dealer','sigstore');
	$company_array = array('GS Wireless', 'All Mobile', 'ECS Wireless', 'A-Z Mobile', 'Loco Mobile', 'Awesome Cellular');
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'company' => $company_array[rand(0,5)],
        'phone' => rand(6191000000,6199999999),
        'address' => '790 Camino de la Reina',
        'city' => 'San Diego',
        'state' => 'CA',
        'zip' => '92108',
        'role' => $role_array[rand(0,2)],
        'password' => bcrypt('1111'),
        'remember_token' => str_random(10),
    ];
});
