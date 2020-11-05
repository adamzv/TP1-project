<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Picture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PicturesTest extends TestCase
{
    use RefreshDatabase,WithFaker;


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
    public function test_can_create_picture()
    {

        $data = [
            'link' => $this->faker->imageUrl(),
            'id_event' => factory(Event::class)->create()->id,
        ];
        $this->withoutExceptionHandling();
        $this->json('POST',route('pictures.store'),$data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    public function test_can_update_picture()
    {
        $event = factory(Event::class)->create()->id;
        $picture = factory(Picture::class)->create()->id;
        $data = [
            'link' => $this->faker->imageUrl(),
            'id_event' => $event,
        ];
        $this->withoutExceptionHandling();
        $this->json('PUT',route('pictures.update', $picture),$data)
            ->assertStatus(200)
            ->assertJson($data);

    }
}
