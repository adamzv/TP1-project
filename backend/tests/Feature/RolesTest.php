<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
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
        $user = factory(User::class)->create(
            [
                'id_role' => '1',
            ]
        );
        Passport::actingAs($user, ['admin-user','moderator-user']);

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
