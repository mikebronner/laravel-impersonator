<?php

use Faker\Generator as Faker;
use GeneaLabs\LaravelImpersonator\Tests\Fixtures\User;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => str_random(12),
    ];
});
