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
    // Create a user
    $user = \App\Models\User::factory()->create();

    
    $eventData = [
        'title' => $this->faker->sentence,
        'description' => $this->faker->paragraph,
        'date' => $this->faker->date,
        'location' => $this->faker->address,
        'type' => $this->faker->randomElement(['type1', 'type2', 'type3']),
        'skills' => $this->faker->words(3), 
    ];

    
    $response = $this->actingAs($user, 'api')
                     ->json('POST', '/api/creatEvent', $eventData);

  
    $response->assertStatus(Response::HTTP_CREATED)
            
             ->assertJsonStructure([
                 'status',
                 'message',
                 'event' => [
                     'id',
                     'title',
                     'description',
                     'date',
                     'location',
                     'type',
                     'skills',
                     'user_id',
                     'created_at',
                     'updated_at',
                 ]
             ]);

  
    $this->assertDatabaseHas('events', [
        'title' => $eventData['title'],
        'description' => $eventData['description'],
        'date' => $eventData['date'],
        'location' => $eventData['location'],
        'type' => $eventData['type'],
        'skills' => json_encode($eventData['skills']), 
        'user_id' => $user->id,
    ]);
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

