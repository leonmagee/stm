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

$factory->define(App\SimUser::class, function (Faker $faker) {
    return [
        'sim_number' => rand(98729237491111111, 98729237499999999),
        'user_id' => function() {
        	/**
        	* @todo this doens't seem to do anything
        	* just auto incrementing 1-10?
        	*/
        	return factory(App\User::class)->create()->id;
        }
    ];
});
