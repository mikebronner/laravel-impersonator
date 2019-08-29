<?php

use Faker\Generator as Faker;
use GeneaLabs\LaravelImpersonator\Tests\Fixtures\User;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => Str::random(12),
    ];
});
