<?php namespace GeneaLabs\LaravelImpersonator\Tests\Feature;

use GeneaLabs\LaravelImpersonator\Tests\Fixtures\User;
use GeneaLabs\LaravelImpersonator\Tests\FeatureTestCase;

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
}
