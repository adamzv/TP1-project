<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Class CitiesTest
 *
 * @author klukak
 */
class CitiesTest extends TestCase
{
    use RefreshDatabase;



    /**
     * SetUP
     */
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
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_city()
    {


        $data = [
            'name' => 'Lapáš',
            'id_state' => factory(State::class)->create()->id,
        ];
        $this->withoutExceptionHandling();
        $this->json('POST', route('cities.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    public function test_can_update_city()
    {
        $state = factory(State::class)->create()->id;
        $city = factory(City::class)->create();
        $data = [
            'name' => 'Veľký Lapáš',
            'id_state' => $state,
        ];
        $this->withoutExceptionHandling();
        $this->json('PUT', route('cities.update', $city->id), $data)
            ->assertStatus(200)
            ->assertJson($data);

    }
}
