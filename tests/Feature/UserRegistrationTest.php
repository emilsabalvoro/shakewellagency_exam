<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_register()
    {
        $data = [
            'username' => 'testuser',
            'first_name' => 'Test',
            'email' => 'testuser@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'username' => 'testuser',
            'email' => 'testuser@example.com'
        ]);
    }

    #[Test]
    public function registration_requires_unique_username_and_email()
    {
        User::factory()->create([
            'username' => 'existinguser',
            'email' => 'existinguser@example.com',
        ]);

        $data = [
            'username' => 'existinguser',
            'first_name' => 'Test',
            'email' => 'existinguser@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(422);  // Unprocessable entity due to validation errors
    }
}