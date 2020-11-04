<?php

namespace Tests\Feature;

use App\Models\Faculty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FacultiesTest extends TestCase
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
    public function test_can_create_faculty()
    {
        $data = ['name' => 'test'];
        $this->withoutExceptionHandling();
        $this->json('POST',route('faculties.store'),$data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    public function test_can_update_faculty()
    {

        $faculty = Faculty::all()->random()->id;
        $data = ['name' => 'testovanie'];
        $this->withoutExceptionHandling();
        $this->json('PUT',route('faculties.update', $faculty),$data)
            ->assertStatus(200)
            ->assertJson($data);

    }
}
