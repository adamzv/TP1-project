<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class CategoryTest
 *
 * @author klukak
 */
class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Creating Category
     */
    public function test_can_create_category()
    {
        $data = ['name' => 'test'];
        $this->json('POST', route('categories.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    /**
     * Test: Updating Category
     */
    public function test_can_update_category()
    {

        $category = factory(Category::class)->create();
        $data = ['name' => 'testovanie'];

        $this->json('PUT', route('categories.update', $category->id), $data)
            ->assertStatus(200)
            ->assertJson($data);

    }

}
