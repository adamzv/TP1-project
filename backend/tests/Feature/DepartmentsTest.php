<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepartmentsTest extends TestCase
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
    public function test_can_create_department()
    {

        $data = [
            'name' => 'test',
            'id_faculty' => Faculty::all()->random()->id,
        ];
        $this->withoutExceptionHandling();
        $this->json('POST',route('departments.store'),$data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    public function test_can_update_department()
    {
        $faculty = Faculty::all()->random()->id;
        $department = Department::all()->random()->id;
        $data = [
            'name' => 'testovanie',
            'id_faculty' => $faculty,
        ];
        $this->withoutExceptionHandling();
        $this->json('PUT',route('departments.update', $department),$data)
            ->assertStatus(200)
            ->assertJson($data);

    }
}
