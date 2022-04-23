<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UrlControllerTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('urls')->insert([
            'name' => 'https://testexample.biz',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }

    public function testStore()
    {
        $fullUrl = $this->faker->url();
        $parsedUrl = parse_url($fullUrl);
        $url = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
        $data['url']['name'] = $url;
        $dataForCheckInDb['name'] = $url;
        //Этот массив вида ['name' => 'http://something.com/'] нужен для тестирования
        //наличия данных в базе, так как инпут в форме - url[name], а assertDatabaseHas должен принять просто name
        $response = $this->post(route('urls.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('urls', $dataForCheckInDb);
    }

    public function testShow()
    {
        $data = [
            'name' => 'https://testshowsdf.com'
        ];
        $id = DB::table('urls')->insertGetId($data);
        $response = $this->get(route('urls.show', $id));
        $response->assertSessionHasNoErrors();
        $response->assertOk();
        $response->assertSeeText($data['name']);
    }
}
