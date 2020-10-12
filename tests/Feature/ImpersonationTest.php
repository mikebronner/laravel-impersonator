<?php

namespace GeneaLabs\LaravelImpersonator\Tests\Feature;

use GeneaLabs\LaravelImpersonator\Tests\FeatureTestCase;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use GeneaLabs\LaravelImpersonator\Tests\Fixtures\App\Models\User;
use GeneaLabs\LaravelImpersonator\Tests\Fixtures\Database\Factories\UserFactory;

class ImpersonationTest extends FeatureTestCase
{
    public function testImpersonatingPageLoads()
    {
        $user = (new UserFactory)->create([
            'canImpersonate' => true,
            'canBeImpersonated' => false,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('impersonatees.index'));

        $response->assertResponseOk();
    }

    public function testImpersonatableUsersAreListed()
    {
        config(['genealabs-laravel-impersonator.user-model' => User::class]);
        $user = (new UserFactory)->create([
            'canImpersonate' => true,
            'canBeImpersonated' => false,
        ]);
        $users = (new UserFactory)->count( 10)->create();

        $response = $this
            ->actingAs($user)
            ->get(route('impersonatees.index'));

        $response->assertResponseOk();
        foreach ($users as $user) {
            $response->see(htmlspecialchars($user->name));
        }
    }

    public function testUserCanBeImpersonated()
    {
        config(['genealabs-laravel-impersonator.user-model' => User::class]);
        $user = (new UserFactory)->create([
            'canImpersonate' => true,
            'canBeImpersonated' => false,
        ]);
        $users = (new UserFactory)->count( 10)->create();

        $response = $this->actingAs($user)
            ->visit(route('impersonatees.index'))
            ->press($users->first()->name);

        $response->assertSessionHas('impersonator', $user);
    }

    public function testMiddlewareCanBeAdjusted()
    {
        $this->withoutExceptionHandling();
        config(['genealabs-laravel-impersonator.user-model' => User::class]);
        config(['genealabs-laravel-impersonator.middleware' => ['web', 'auth', 'password.confirm' => ['except' => ['destroy']]]]);

        $user = (new UserFactory)->create([
            'canImpersonate' => true,
            'canBeImpersonated' => false,
        ]);
        $users = (new UserFactory)->count(10) ->create();

        $this->expectException(RouteNotFoundException::class);
        $this->expectExceptionMessage('Route [password.confirm] not defined.');

        $response = $this
            ->actingAs($user)
            ->get(route('impersonatees.index'));
    }
}
