<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Class UsersTest
 *
 * @author klukak
 */
class UsersTest extends TestCase
{
    use WithFaker, RefreshDatabase;

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
     * Test: Creating User
     */
    public function test_can_create_user()
    {
        $data = [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password,
            'id_role' => Role::all()->random()->id,


        ];
        $this->withoutExceptionHandling();
        $this->json('POST', route('users.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    /**
     * Test: Updating User
     */
    public function test_can_update_user()
    {

        $user = factory(User::class)->create();
        $data = [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password,
            'id_role' => Role::all()->random()->id,


        ];
        $this->withoutExceptionHandling();
        $this->json('PUT', route('users.update', $user), $data)
            ->assertStatus(200)
            ->assertJson($data);

    }

}
