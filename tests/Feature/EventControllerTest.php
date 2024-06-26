<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testStoreEvent()
{
    $user = User::factory()->create();
   

    $eventData = [
        'title' => $this->faker->word,
        'description' => $this->faker->word,
        'date' => $this->faker->date,
        'location' => $this->faker->word,
        'type' => $this->faker->word,
        'competences' => $this->faker->word, 
        'user_id' => $this->faker->randomDigit, 	
    ];

    $user = User::factory()->create();
    
  
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
            'competences', 
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
        'competences' => $eventData['competences'],
        'user_id' => $user->id,
    ]);
}


public function testShowEvent()
{
    $user = User::factory()->create();
    
    $event = Event::factory()->create([
        'title' => $this->faker->word,
        'description' => $this->faker->word,
        'date' => $this->faker->date,
        'location' => $this->faker->word,
        'type' => $this->faker->word,
        'competences' => $this->faker->word, 
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user, 'api')
                     ->json('GET', '/api/event/' . $event->id);
    
    $response->assertStatus(Response::HTTP_OK)
            
             ->assertJsonStructure([
                 'status',
                 'event' => [
                     'id',
                     'title',
                     'description',
                     'date',
                     'location',
                     'type',
                     'competences',
                     'user_id',
                 ]
             ])
    
             ->assertJson([
                 'status' => 'success',
                 'event' => $event->toArray(),
             ]);
}



}

