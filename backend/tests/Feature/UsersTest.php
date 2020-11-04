<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp():void
    {
        parent::setUP();
        $this->seed();


    }



    /**
     * A basic feature test example.
     *
     * @return void
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
        $this->json('POST',route('users.store'),$data)
            ->assertStatus(201)
            ->assertJson($data);


    }

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
        $this->json('PUT',route('users.update', $user),$data)
            ->assertStatus(200)
            ->assertJson($data);

    }

}
