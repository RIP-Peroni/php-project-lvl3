<?php

namespace Tests\Feature;

use App\Models\UrlCheck;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\Url;

class UrlCheckControllerTest extends TestCase
{
    use WithFaker;

    public function testStore()
    {
        $name = 'https://testexample.com';
        $url = new Url();
        $url->fill(['name' => $name])->save();
        $id = $url->id;
        $content = file_get_contents('tests/fixtures/testsite.html');
        Http::fake([$name => Http::response($content, 200)]);
        $expectedData = [
            'url_id' => $id,
            'status_code' => 200,
            'title' => 'example title',
            'description' => 'test content',
            'h1' => "I ain't the sharpest tool in the shed",
        ];
        $response = $this->post(route('url.checks.store', $id));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('url_checks', $expectedData);
    }
}
