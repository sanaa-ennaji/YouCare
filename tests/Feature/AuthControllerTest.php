<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testRegister()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'role' => $this->faker->randomElement(['organisator', 'benevole', 'admin']), 
            'phone' => $this->faker->numerify('##########'), 
        ];

        $response = $this->json('POST', '/api/register', $userData);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'role' => $userData['role'],
                    'phone' => $userData['phone'],
                ],
                'authorisation' => [
                    'token' => $response['authorisation']['token'],
                    'type' => 'bearer',
                ]
            ]);

        
        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'role' => $userData['role'],
            'phone' => $userData['phone'],
        ]);
    }
}
