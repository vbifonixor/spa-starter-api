<?php

use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = Hash::make('secret'),
    ];
});

$factory->define(App\Author::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Book::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'author_id' => function () {
            return factory(App\Author::class)->create()->id;
        },
    ];
});
