<?php

namespace Tests\Feature;

use App\Models\Faculty;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
