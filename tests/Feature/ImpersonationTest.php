<?php

namespace GeneaLabs\LaravelImpersonator\Tests\Feature;

use GeneaLabs\LaravelImpersonator\Tests\Fixtures\User;
use GeneaLabs\LaravelImpersonator\Tests\TestCase;

class ImpersonationTest extends TestCase
{
    public function test_impersonating_page_loads(): void
    {
        $user = User::factory()->create([
            'canImpersonate' => true,
            'canBeImpersonated' => false,
        ]);

        $response = $this->actingAs($user)
            ->get(route('impersonatees.index'));

        $response->assertOk();
    }

    public function test_impersonatable_users_are_listed(): void
    {
        config(['genealabs-laravel-impersonator.user-model' => User::class]);

        $user = User::factory()->create([
            'canImpersonate' => true,
            'canBeImpersonated' => false,
        ]);
        $users = User::factory()->count(10)->create();

        $response = $this->actingAs($user)
            ->get(route('impersonatees.index'));

        $response->assertOk();

        foreach ($users as $listedUser) {
            $response->assertSee(htmlspecialchars($listedUser->name));
        }
    }

    public function test_user_can_be_impersonated(): void
    {
        config(['genealabs-laravel-impersonator.user-model' => User::class]);

        $user = User::factory()->create([
            'canImpersonate' => true,
            'canBeImpersonated' => false,
        ]);
        $impersonatee = User::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('impersonatees.update', $impersonatee));

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($impersonatee);
    }

    public function test_impersonation_can_be_ended(): void
    {
        config(['genealabs-laravel-impersonator.user-model' => User::class]);

        $user = User::factory()->create([
            'canImpersonate' => true,
            'canBeImpersonated' => false,
        ]);
        $impersonatee = User::factory()->create();

        // Start impersonation
        $this->actingAs($user)
            ->put(route('impersonatees.update', $impersonatee));

        // End impersonation
        $response = $this->delete(route('impersonatees.destroy', $impersonatee));

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }
}
