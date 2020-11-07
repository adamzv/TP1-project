<?php

namespace Tests\Feature;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class RolesTest
 *
 * @author klukak
 */
class RolesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup
     */
    public function setUp(): void
    {
        parent::setUP();
        $this->seed();
    }

    /**
     * Test: creating roles
     */
    public function test_can_create_role()
    {
        $data = ['type' => 'test'];
        $this->withoutExceptionHandling();
        $this->json('POST', route('roles.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    /**
     * Test: updating roles
     */
    public function test_can_update_role()
    {

        $role = Role::all()->random()->id;
        $data = ['type' => 'testovanie'];
        $this->withoutExceptionHandling();
        $this->json('PUT', route('roles.update', $role), $data)
            ->assertStatus(200)
            ->assertJson($data);

    }
}
