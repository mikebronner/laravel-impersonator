<?php namespace GeneaLabs\LaravelImpersonator\Tests\Feature;

use GeneaLabs\LaravelImpersonator\Tests\TestCase;
use App\User;

class ImpersonateUsersTest extends TestCase
{
    public function testThatNonAdminNonLoggedInUserCannotImpersonateUsers()
    {
        $user = factory(User::class)->create();

        $response = $this->withExceptionHandling()
            ->post(route('impersonatees.store', $user));

        $response->assertRedirect('login');
    }

    public function testThatNonAdminLoggedInUserCannotImpersonateUsers()
    {
        $user = factory(User::class)->create();
        $impersonatedUser = factory(User::class)->create();

        $response = $this->withExceptionHandling()
            ->actingAs($user)
            ->put(route('impersonatees.update', $impersonatedUser), []);

        $response->assertStatus(403);
    }

    public function testThatAdminLoggedInUserCanImpersonateUsers()
    {
        $user = factory(User::class)->create(['canImpersonate' => true]);
        $impersonatedUser = factory(User::class)->create();

        $response = $this->withExceptionHandling()
            ->actingAs($user)
            ->put(route('impersonatees.update', $impersonatedUser), []);

        $this->assertEquals(auth()->user()->id, $impersonatedUser->id);
    }
}
