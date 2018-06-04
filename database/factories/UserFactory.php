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
	$role_array = array('admin', 'user');
	$company_array = array('GS Wireless', 'All Mobile', 'ECS Wireless', 'A-Z Mobile', 'Loco Mobile', 'Awesome Cellular');
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'company' => $company_array[rand(0,5)],
        'role' => $role_array[rand(0,1)],
        'password' => bcrypt('1111'),
        'remember_token' => str_random(10),
    ];
});
