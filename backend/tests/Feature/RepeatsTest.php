<?php

namespace Tests\Feature;

use App\Models\Repeat;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RepeatsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_repeat()
    {


        $data = [
            'repeatUnit' => $this->faker->randomElement(['rok', 'mesiac', 'den']),
            'repeatNumber' => $this->faker->randomDigitNot(0),
            'repeatUntil' => '2001-08-03 09:42:42.000000',
        ];
        $this->withoutExceptionHandling();
        $this->json('POST',route('repeats.store'),$data)
            ->assertStatus(201)
            ->assertJson($data);


    }

    public function test_can_update_repeat()
    {

        $repeat = factory(Repeat::class)->create();
        $data = [
            'repeatUnit' => $this->faker->randomElement(['rok', 'mesiac', 'den']),
            'repeatNumber' => $this->faker->randomDigitNot(0),
            'repeatUntil' => '2001-08-03 09:42:42.000000'
        ];
        $this->withoutExceptionHandling();
        $this->json('PUT',route('repeats.update', $repeat->id),$data)
            ->assertStatus(200)
            ->assertJson($data);

    }
}
