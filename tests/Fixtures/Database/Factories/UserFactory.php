<?php

namespace GeneaLabs\LaravelImpersonator\Tests\Fixtures\Database\Factories;

use GeneaLabs\LaravelImpersonator\Tests\Fixtures\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Str::random(12),
        ];
    }
}
