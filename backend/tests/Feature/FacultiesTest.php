<?php

namespace Tests\Feature;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Class FacultiesTest
 *
 * @author klukak
 */
class FacultiesTest extends TestCase
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
     * Test: Creating Faculties
     */
    public function test_can_create_faculty()
    {
        $data = ['name' => 'politologia'];
        $this->withoutExceptionHandling();
        $this->json('POST', route('faculties.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    /**
     * Test: Updating Faculties
     */
    public function test_can_update_faculty()
    {

        $faculty = Faculty::all()->random()->id;
        $data = ['name' => 'testovanie'];
        $this->withoutExceptionHandling();
        $this->json('PUT', route('faculties.update', $faculty), $data)
            ->assertStatus(200)
            ->assertJson($data);

    }
}
