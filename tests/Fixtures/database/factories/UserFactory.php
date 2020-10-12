<?php

namespace GeneaLabs\LaravelImpersonator\Tests\Fixtures\Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use GeneaLabs\LaravelImpersonator\Tests\Fixtures\App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Str::random(12),
        ];
    }
}
