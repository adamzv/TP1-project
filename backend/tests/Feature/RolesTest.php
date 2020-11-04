<?php

namespace Tests\Feature;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use RolesSeeder;
use Tests\TestCase;

/**
 * Class RolesTest
 *
 * @author klukak
 */
class RolesTest extends TestCase
{
    use RefreshDatabase;

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
    public function test_can_create_role()
    {
        $data = ['type' => 'test'];
        $this->withoutExceptionHandling();
        $this->json('POST',route('roles.store'),$data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    public function test_can_update_role()
    {

        $role = Role::all()->random()->id;
        $data = ['type' => 'testovanie'];
        $this->withoutExceptionHandling();
        $this->json('PUT',route('roles.update', $role),$data)
            ->assertStatus(200)
            ->assertJson($data);

    }
}
