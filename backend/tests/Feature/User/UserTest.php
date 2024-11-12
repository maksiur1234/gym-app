<?php

namespace Tests\Feature\User;

use App\Models\Role;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testFetchUsersPagination()
    {
        $user = User::factory()->create();

        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/all-users');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'desc',
                    'profile_photo_path',
                ]
            ]
        ]);
    }
    public function testAdminCanUpdateAnyUser()
    {
        $adminRole = Role::factory()->create(['id' => 3, 'name' => 'admin']);
        $trainerRole = Role::factory()->create(['id' => 2, 'name' => 'trainer']);
        $userRole = Role::factory()->create(['id' => 1, 'name' => 'normal']);
    
        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $userToUpdate = User::factory()->create(['role_id' => $userRole->id]);
    
        $this->actingAs($admin);
    
        $data = [
            'name' => 'Updated Name',
            'surname' => 'Updated Surname',
            'email' => 'updated.email@example.com',
            'role_id' => $trainerRole->id, 
        ];
    
        $response = $this->putJson("/update-user/{$userToUpdate->id}", $data);
    
        $response->assertStatus(200);
    
        $userToUpdate->refresh();
    
        $this->assertEquals('Updated Name', $userToUpdate->name);
        $this->assertEquals('Updated Surname', $userToUpdate->surname);
        $this->assertEquals('updated.email@example.com', $userToUpdate->email);
        $this->assertEquals($trainerRole->id, $userToUpdate->role_id);  
    }
    
    public function testNonAdminCannotUpdateAnyUser()
    {
        $adminRole = Role::factory()->create(['id' => 3, 'name' => 'admin']);
        $trainerRole = Role::factory()->create(['id' => 2, 'name' => 'trainer']);
        $userRole = Role::factory()->create(['id' => 1, 'name' => 'normal']);

        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $trainer = User::factory()->create(['role_id' => $trainerRole->id]);
        $userToUpdate = User::factory()->create(['role_id' => $userRole->id]);

        $this->actingAs($trainer);

        $data = [
            'name' => 'Updated Name',
            'surname' => 'Updated Surname',
            'email' => 'updated.email@example.com',
        ];

        $response = $this->putJson("/update-user/{$userToUpdate->id}", $data);

        $response->assertStatus(403);
    }



}
