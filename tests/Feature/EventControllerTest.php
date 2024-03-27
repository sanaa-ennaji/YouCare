<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testStoreEvent()
    {
        $user = \App\Models\User::factory()->create();

        $eventData = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'date' => now()->format('Y-m-d'),
            'location' => $this->faker->city,
            'type' => $this->faker->randomElement(['type1', 'type2', 'type3']),
            'skills' => ['skill1', 'skill2'],
        ];

        $response = $this->actingAs($user, 'api')
                         ->json('POST', '/api/events', $eventData);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'event created successfully',
                 ]);

        $this->assertDatabaseHas('events', $eventData);
    }

    public function testDestroyEvent()
    {
        $user = \App\Models\User::factory()->create();
        $event = \App\Models\Event::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')
                         ->json('DELETE', "/api/events/{$event->id}");

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'event deleted successfully',
                 ]);

        $this->assertDeleted('events', ['id' => $event->id]);
    }
}

