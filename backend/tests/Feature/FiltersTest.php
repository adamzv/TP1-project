<?php

namespace Tests\Feature;

use App\Models\Filter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class FiltersTest
 *
 * @author klukak
 */
class FiltersTest extends TestCase
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
     * Test: Creating Filters
     */
    public function test_can_create_filter()
    {
        $data = ['name' => 'test'];
        $this->withoutExceptionHandling();
        $this->json('POST', route('filters.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    /**
     * Test: Updating Filters
     */
    public function test_can_update_filter()
    {

        $filter = Filter::all()->random()->id;
        $data = ['name' => 'testovanie'];
        $this->withoutExceptionHandling();
        $this->json('PUT', route('filters.update', $filter), $data)
            ->assertStatus(200)
            ->assertJson($data);

    }
}
