<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Place;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlacesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_city()
    {

        factory(State::class)->create();
        $data = [
            'name' => 'test',
            'id_city' => factory(City::class)->create()->id,
        ];
        $this->withoutExceptionHandling();
        $this->json('POST',route('places.store'),$data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    public function test_can_update_city()
    {
        factory(State::class)->create();
        $city = factory(City::class)->create()->id;
        $place = factory(Place::class)->create();
        $data = [
            'name' => 'testovanie',
            'id_city' => $city,
        ];
        $this->withoutExceptionHandling();
        $this->json('PUT',route('places.update', $place->id),$data)
            ->assertStatus(200)
            ->assertJson($data);

    }
}
