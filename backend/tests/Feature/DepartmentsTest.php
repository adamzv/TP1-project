<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class DepartmentTest
 *
 * @author klukak
 */
class DepartmentsTest extends TestCase
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
     * Test: Creating Department
     */
    public function test_can_create_department()
    {

        $data = [
            'name' => 'Informatika',
            'id_faculty' => Faculty::all()->random()->id,
        ];
        $this->withoutExceptionHandling();
        $this->json('POST', route('departments.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    /**
     * Test: Updating departments
     */
    public function test_can_update_department()
    {
        $faculty = Faculty::all()->random()->id;
        $department = Department::all()->random()->id;
        $data = [
            'name' => 'testovanie',
            'id_faculty' => $faculty,
        ];
        $this->withoutExceptionHandling();
        $this->json('PUT', route('departments.update', $department), $data)
            ->assertStatus(200)
            ->assertJson($data);

    }
}
