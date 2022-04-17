<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Url;


class UrlControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    protected function setUp(): void
    {
        parent::setUp();
//        $this->setUpFaker();
        Url::factory()->count(2)->make();
    }

    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }

//    public function testCreate()
//    {
//        $response = $this->get(route('urls.create'));
//        $response->assertOk();
//    }

//    public function testEdit()
//    {
//        $article = Url::factory()->create();
//        $response = $this->get(route('urls.edit', [$article]));
//        $response->assertOk();
//    }

    public function testStore()
    {
        $data = Url::factory()->make()->only('url');
        $fullUrl = $this->faker->url();
        $parsedUrl = parse_url($fullUrl);
        $url = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
        $data['url']['name'] = $url;
        $dataForCheckInDb['name'] = $url; //Этот массив вида ['name' => 'http://something.com/'] нужен для тестирования
        //наличия данных в базе, так как инпут в форме - url[name], а assertDatabaseHas должен принять просто name
        $response = $this->post(route('urls.store'), $data);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('urls', $dataForCheckInDb);
    }

//    public function testUpdate()
//    {
//        $article = Url::factory()->create();
//        $data = Url::factory()->make()->only('name', 'body');
//
//        $response = $this->patch(route('urls.update', $article), $data);
//        $response->assertRedirect(route('urls.index'));
//        $response->assertSessionHasNoErrors();
//
//        $this->assertDatabaseHas('urls', $data);
//    }
//
//    public function testDestroy()
//    {
//        $article = Url::factory()->create();
//        $response = $this->delete(route('urls.destroy', [$article]));
//        $response->assertSessionHasNoErrors();
//        $response->assertRedirect(route('urls.index'));
//
//        $this->assertDatabaseMissing('urls', $article->only('id'));
//    }
}