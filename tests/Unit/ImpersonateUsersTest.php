<?php

namespace GeneaLabs\LaravelImpersonator\Tests\Unit;

use GeneaLabs\LaravelImpersonator\Tests\UnitTestCase;
use GeneaLabs\LaravelImpersonator\Tests\Fixtures\App\Models\User;
use GeneaLabs\LaravelImpersonator\Tests\Fixtures\Database\Factories\UserFactory;

class ImpersonateUsersTest extends UnitTestCase
{
    public function testThatNonAdminNonLoggedInUserCannotImpersonateUsers()
    {
        $user = (new UserFactory)->create();

        $response = $this->post(route('impersonatees.store', $user));

        $response->assertRedirect('login');
    }

    public function testThatNonAdminLoggedInUserCannotImpersonateUsers()
    {
        $user = (new UserFactory)->create();
        $impersonatedUser = (new UserFactory)->create();

        $response = $this->actingAs($user)
            ->put(route('impersonatees.update', $impersonatedUser), []);

        $response->assertStatus(403);
    }

    public function testThatAdminLoggedInUserCanImpersonateUsers()
    {
        $user = (new UserFactory)->create(['canImpersonate' => true]);
        $impersonatedUser = (new UserFactory)->create();

        $this->actingAs($user)
            ->put(route('impersonatees.update', $impersonatedUser), []);

        $this->assertEquals(auth()->user()->id, $impersonatedUser->id);
    }
}
