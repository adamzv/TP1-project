<?php

namespace Tests\Feature;

use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;


/**
 * Class StatesTest
 *
 * @author klukak
 */
class StatesTest extends TestCase
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
     * Test: creating state
     */
    public function test_can_create_state()
    {
        $data = ['name' => 'USA'];
        $this->withoutExceptionHandling();
        $this->json('POST', route('states.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    /**
     * Test: Updating state
     */
    public function test_can_update_state()
    {

        $state = factory(State::class)->create();
        $data = ['name' => 'testovanie'];
        $this->withoutExceptionHandling();
        $this->json('PUT', route('states.update', $state->id), $data)
            ->assertStatus(200)
            ->assertJson($data);

    }

}
