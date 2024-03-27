<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testStoreEvent()
    {
        $user = \App\Models\User::factory()->create();

        $eventData = [
            'title' => $this->faker->sentence, 
            'description' => $this->faker->test,
            'date' => $this->faker->date,
            'location' => $this->faker->address,
            'type' => $this->faker->randomElement(['type1', 'type2', 'type3']),
            'skills' => ['skill1', 'skill2', 'skill3'],
        ];

        dump($eventData['description']);

        $response = $this->actingAs($user, 'api')
                         ->json('POST', '/api/creatEvent', $eventData);

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
                         ->json('DELETE', "/api/event/{$event->id}");

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'event deleted successfully',
                 ]);

        $this->assertDeleted('events', ['id' => $event->id]);
    }
}

