<?php

namespace Tests\Feature;

use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


/**
 * Class StatesTest
 *
 * @author klukak
 */
class StatesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: creating state
     */
    public function test_can_create_state()
    {
        $data = ['name' => 'Slovensko'];
        $this->withoutExceptionHandling();
        $this->json('POST',route('states.store'),$data)
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
        $this->json('PUT',route('states.update', $state->id),$data)
            ->assertStatus(200)
            ->assertJson($data);

    }

}
