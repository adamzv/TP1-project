<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class CategoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_category()
    {
        $data = ['name' => 'test'];
        $this->withoutExceptionHandling();
       $this->json('POST',route('categories.store'),$data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    public function test_can_update_category()
    {

        $category = factory(Category::class)->create();
        $data = ['name' => 'testovanie'];

        $this->withoutExceptionHandling();
        $this->json('PUT',route('categories.update', $category->id),$data)
            ->assertStatus(200)
            ->assertJson($data);

    }

}
