<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\UrlCheck;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DiDom\Document;

class UrlCheckController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function store(Request $request, $id): RedirectResponse
    {
        $url = Url::findOrFail($id);
        $name = $url->name;
        abort_unless($url, 404);
        try {
            $response = Http::get($name);
            $statusCode = $response->status();
//            $document = new Document($response->body());
//            $h1 = optional($document->first('h1'))->text();
            $data = [
                'url_id' => $id,
                'status_code' => $statusCode,
            ];
            $newCheck = new UrlCheck();
            $newCheck->fill($data);
            $newCheck->save();
            flash('Страница успешно проверена')->success();
        } catch (GuzzleException $exception) {
            flash($exception->getMessage())->error();
        }


        return redirect()->route('urls.show', ['url' => $id]);
    }

}
