<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Class CategoryTest
 *
 * @author klukak
 */
class CategoryTest extends TestCase
{
    use RefreshDatabase;

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
