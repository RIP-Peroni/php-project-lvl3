<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UrlCheckControllerTest extends TestCase
{
    use WithFaker;

    public function testStore()
    {
        $name = 'https://testshowsdf.com';
        $data = [
            'name' => $name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        $id = DB::table('urls')->insertGetId($data);
        $content = file_get_contents('tests/fixtures/testsite.html');
        Http::fake([$name => Http::response($content)]);
        $expectedData = [
            'url_id' => $id,
            'status_code' => 200,
            'title' => 'example title',
            'description' => 'test content',
            'h1' => "I ain't the sharpest tool in the shed",
        ];
        $response = $this->post(route('urls.checks.store', $id));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('url_checks', $expectedData);
    }
}
