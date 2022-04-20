<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\UrlCheck;
use Illuminate\Http\Client\HttpClientException;
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
//        $newCheck = UrlCheck::create();
        $url = Url::findOrFail($id);
        $name = $url->name;
        abort_unless($url, 404);
        try {
            $response = Http::get($name);
            $document = new Document($response->body());
//            dd($response->body());
            $h1 = optional($document->first('h1'))->text();
//            dd($response->status());
            $request->session()->flash('success', 'Url checked successfully');
        } catch (HttpClientException $exception) {
            flash($exception->getMessage())->error();
//            $request->session()->flash($exception->getMessage());
//            throw new \Exception($exception);
//            throw new HttpClientException($exception);
        }

        $data = ['url_id' => $id];
        $newCheck = new UrlCheck();
        $newCheck->fill($data);
        $newCheck->save();
        return redirect()->route('urls.show', ['url' => $id]);
    }

}
