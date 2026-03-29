<?php

namespace GeneaLabs\LaravelImpersonator\Tests\Unit;

use GeneaLabs\LaravelImpersonator\Tests\Fixtures\User;
use GeneaLabs\LaravelImpersonator\Tests\TestCase;

class ImpersonateUsersTest extends TestCase
{
    public function test_non_admin_non_logged_in_user_cannot_impersonate_users(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('impersonatees.store', $user));

        $response->assertRedirect('login');
    }

    public function test_non_admin_logged_in_user_cannot_impersonate_users(): void
    {
        $user = User::factory()->create();
        $impersonatedUser = User::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('impersonatees.update', $impersonatedUser), []);

        $response->assertStatus(403);
    }

    public function test_admin_logged_in_user_can_impersonate_users(): void
    {
        $user = User::factory()->create(['canImpersonate' => true]);
        $impersonatedUser = User::factory()->create();

        $this->actingAs($user)
            ->put(route('impersonatees.update', $impersonatedUser), []);

        $this->assertEquals(auth()->user()->id, $impersonatedUser->id);
    }
}
