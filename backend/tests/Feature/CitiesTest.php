<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CitiesTest extends TestCase
{
    use RefreshDatabase;





    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_city()
    {

        $data = [
            'name' => 'test',
            'id_state' => factory(State::class)->create()->id,
            ];
        $this->withoutExceptionHandling();
        $this->json('POST',route('cities.store'),$data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    public function test_can_update_city()
    {
        $state = factory(State::class)->create()->id;
        $city = factory(City::class)->create();
        $data = [
            'name' => 'testovanie',
            'id_state' => $state,
        ];
        $this->withoutExceptionHandling();
        $this->json('PUT',route('cities.update', $city->id),$data)
            ->assertStatus(200)
            ->assertJson($data);

    }
}
