<?php

namespace Tests\Unit\User;

use App\Models\Role;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testCannotUpdateInvalidEmail()
    {
        $adminRole = Role::factory()->create(['id' => 3, 'name' => 'admin']);
        $user = User::factory()->create(['role_id' => $adminRole->id]);

        $this->actingAs($user);

        $data = [
            'name' => 'Updated Name',
            'surname' => 'Updated Surname',
            'email' => 'invalid-email',
            'role_id' => 3,
        ];

        $response = $this->putJson("/update-user/{$user->id}", $data);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('email');
    }

    public function testCannotUpdateNonExistingUser()
    {
        $adminRole = Role::factory()->create(['id' => 3, 'name' => 'admin']);
        $admin = User::factory()->create(['role_id' => $adminRole->id]);

        $this->actingAs($admin);

        $userToUpdate = User::find(9999999999999);
        $this->assertNull($userToUpdate);

        $data = [
            'name' => 'Updated Name',
            'surname' => 'Updated Surname',
            'email' => 'testMail@gmail.com',
            'role_id' => 3,
        ];

        $response = $this->putJson("/update-user/99999999", $data);

        $response->assertStatus(403);
    }

    public function testViewReturnsUsersView()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/users');

        $response->assertStatus(200);
        $response->assertViewIs('users');
    }

    public function testViewReturnsDashboardView()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

    public function testIndexReturnsUserWhenAuthenticated()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/fetch-user-data');

        $response->assertStatus(200);
        $response->assertJson([
            'user' => [
                'id' => $user->id,
                'name' => $user->name
            ]
        ]);
    }

    public function testIndexReturnsUnauthorizedWhenNotAuthenticated()
    {
        $response = $this->getJson('/fetch-user-data');

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
}
