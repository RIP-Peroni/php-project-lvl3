<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function homeTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
    }
}
