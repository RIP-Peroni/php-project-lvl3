<?php

namespace Tests\Feature;

use App\Models\UrlCheck;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Url;


class UrlCheckControllerTest extends TestCase
{
    use WithFaker;

    public function testStore()
    {
        $data = [
            'name' => 'https://something.com',
        ];

        $url = new Url();
        $url->fill($data)->save();
        $id = $url->id;
        $expectedData = [
            'url_id' => $id,
        ];
        $response = $this->post(route('url.checks.store', $id));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('url_checks', $expectedData);
    }
}
