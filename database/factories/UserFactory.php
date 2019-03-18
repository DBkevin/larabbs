<?php

use Illuminate\Support\Str;
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

$factory->define(App\Models\User::class, function (Faker $faker) {
    $created_at=$faker->dateTimeThisYear();
    $updated_at=$faker->dateTimeThisMonth();
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('123123'),
        'introduction'=>$faker->sentence(),
        'remember_token' => Str::random(10),
        'created_at'=>$created_at,
        'updated_at'=>$updated_at,
    ];
});
