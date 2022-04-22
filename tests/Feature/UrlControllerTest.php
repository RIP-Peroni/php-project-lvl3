<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Url;

class UrlControllerTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Url::factory()->count(2)->make();
    }

    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }

//    public function testStore()
//    {
//        $data = Url::factory()->make()->only('url');
//        $fullUrl = $this->faker->url();
//        $parsedUrl = parse_url($fullUrl);
//        $url = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
//        $data['url']['name'] = $url;
//        $dataForCheckInDb['name'] = $url;
//        //Этот массив вида ['name' => 'http://something.com/'] нужен для тестирования
//        //наличия данных в базе, так как инпут в форме - url[name], а assertDatabaseHas должен принять просто name
//        $response = $this->post(route('urls.store'), $data);
//        $response->assertStatus(302);
//        $response->assertSessionHasNoErrors();
//
//        $this->assertDatabaseHas('urls', $dataForCheckInDb);
//    }

    public function testShow()
    {
        $url = new Url();
        $data = [
            'name' => 'https://testshowsdf.com'
        ];
        $url->fill($data)->save();
        $checks = $url->urlChecks();
        $response = $this->get(route('urls.show', $url, $checks));
        $response->assertSessionHasNoErrors();
        $response->assertOk();
        $response->assertSeeText($data['name']);
    }
}
