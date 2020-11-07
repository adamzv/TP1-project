<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\Place;
use App\Models\Repeat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Class EventsTest
 *
 * @author klukak
 */
class EventsTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    /**
     * Setup
     */
    public function setUp():void
    {
        parent::setUP();
        $this->seed();
    }

    /**
     * Test: Creating Events
     */
    public function test_can_create_event()
    {


        $data = [
            'name' => $this->faker->numerify('Event ##'),
            'desc' => $this->faker->text($maxNbChars = 500),
            'room' => $this->faker->numerify('S-###'),
            'beginning' => '2001-08-03 09:42:42.000000',
            'end' => '2001-10-03 09:42:42.000000',
            'attendance_limit' => $this->faker->numberBetween($min = 20, $max = 300),
            'id_user' => factory(User::class)->create()->id,
            'id_place' => factory(Place::class)->create()->id,
            'id_faculty' => Faculty::all()->random()->id,
            'id_department' =>  Department::all()->random()->id,
            'id_repeat' => factory(Repeat::class)->create()->id,

        ];
        $this->withoutExceptionHandling();
        $this->json('POST',route('events.store'),$data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    /**
     * Test: Updating Events
     */
    public function test_can_update_event()
    {


        $event = factory(Event::class)->create();
        $data = [
            'name' => $this->faker->numerify('Event ##'),
            'desc' => $this->faker->text($maxNbChars = 500),
            'room' => $this->faker->numerify('S-###'),
            'beginning' => '2020-08-03 09:42:42.000000',
            'end' => '2020-10-03 09:42:42.000000',
            'attendance_limit' => $this->faker->numberBetween($min = 20, $max = 300),
            'id_user' => factory(User::class)->create()->id,
            'id_place' => factory(Place::class)->create()->id,
            'id_faculty' => Faculty::all()->random()->id,
            'id_department' =>  Department::all()->random()->id,
            //'id_repeat' => factory(Repeat::class)->create()->id,
        ];
        $this->withoutExceptionHandling();
        $this->json('PUT',route('events.update', $event->id),$data)
            ->assertStatus(200)
            ->assertJson($data);

    }
}
