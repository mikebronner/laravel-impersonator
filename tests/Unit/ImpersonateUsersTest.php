<?php namespace GeneaLabs\LaravelImpersonator\Tests\Unit;

use GeneaLabs\LaravelImpersonator\Tests\Fixtures\User;
use GeneaLabs\LaravelImpersonator\Tests\UnitTestCase;

class ImpersonateUsersTest extends UnitTestCase
{
    public function testThatNonAdminNonLoggedInUserCannotImpersonateUsers()
    {
        $user = factory(User::class)->create();

        $response = $this->post(route('impersonatees.store', $user));

        $response->assertRedirect('login');
    }

    public function testThatNonAdminLoggedInUserCannotImpersonateUsers()
    {
        $user = factory(User::class)->create();
        $impersonatedUser = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->put(route('impersonatees.update', $impersonatedUser), []);

        $response->assertStatus(403);
    }

    public function testThatAdminLoggedInUserCanImpersonateUsers()
    {
        $user = factory(User::class)->create(['canImpersonate' => true]);
        $impersonatedUser = factory(User::class)->create();

        $this->actingAs($user)
            ->put(route('impersonatees.update', $impersonatedUser), []);

        $this->assertEquals(auth()->user()->id, $impersonatedUser->id);
    }
}
