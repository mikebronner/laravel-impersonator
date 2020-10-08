<?php namespace GeneaLabs\LaravelImpersonator\Tests\Feature;

use GeneaLabs\LaravelImpersonator\Tests\Fixtures\User;
use GeneaLabs\LaravelImpersonator\Tests\FeatureTestCase;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class ImpersonationTest extends FeatureTestCase
{
    public function testImpersonatingPageLoads()
    {
        $user = factory(User::class)->create([
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
        $user = factory(User::class)->create([
            'canImpersonate' => true,
            'canBeImpersonated' => false,
        ]);
        $users = factory(User::class, 10)->create();

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
        $user = factory(User::class)->create([
            'canImpersonate' => true,
            'canBeImpersonated' => false,
        ]);
        $users = factory(User::class, 10)->create();

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

        $user = factory(User::class)->create([
            'canImpersonate' => true,
            'canBeImpersonated' => false,
        ]);
        $users = factory(User::class, 10)->create();

        $this->expectException(RouteNotFoundException::class);
        $this->expectExceptionMessage('Route [password.confirm] not defined.');

        $response = $this
            ->actingAs($user)
            ->get(route('impersonatees.index'));
    }
}
