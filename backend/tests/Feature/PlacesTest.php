<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Place;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Class PlacesTest
 *
 * @author klukak
 */
class PlacesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUP();
        $this->seed();
        $user = factory(User::class)->create(
            [
                'id_role' => '1',
            ]
        );
        Passport::actingAs($user, ['admin-user','moderator-user']);

    }
    /**
     * Test: Creating cities
     */
    public function test_can_create_place()
    {

        factory(State::class)->create();
        $data = [
            'name' => 'Za školou 8111',
            'id_city' => factory(City::class)->create()->id,
        ];
        $this->withoutExceptionHandling();
        $this->json('POST', route('places.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    /**
     * Test: Updating cities
     */
    public function test_can_update_place()
    {
        factory(State::class)->create();
        $city = factory(City::class)->create()->id;
        $place = factory(Place::class)->create();
        $data = [
            'name' => 'testovanie',
            'id_city' => $city,
        ];
        $this->withoutExceptionHandling();
        $this->json('PUT', route('places.update', $place->id), $data)
            ->assertStatus(200)
            ->assertJson($data);

    }
}
