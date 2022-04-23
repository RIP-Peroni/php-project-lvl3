<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\UrlCheck;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use DiDom\Document;

class UrlCheckController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function store(int $id): RedirectResponse
    {
        $url = DB::table('urls')->find($id);
        abort_unless($url, 404);
        try {
            $response = Http::get($url->name);
            $statusCode = $response->status();
            $document = new Document($response->body());
            $h1 = optional($document->first('h1'))->text();
            $title = optional($document->first('title'))->text();
            $description = optional($document->first('meta[name=description]'))->getAttribute('content');
            $data = [
                'url_id' => $id,
                'status_code' => $statusCode,
                'h1' => $h1,
                'title' => $title,
                'description' => $description,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            DB::table('url_checks')->insert($data);
            flash('Страница успешно проверена')->success();
        } catch (\Exception $exception) {
            flash($exception->getMessage())->error();
            return back();
        }

        return redirect()->route('urls.show', ['url' => $id]);
    }
}
