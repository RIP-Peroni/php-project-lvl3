<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlPostRequest;
use App\Models\Url;
use App\Models\UrlCheck;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $urls = Url::query()->orderBy('created_at', 'ASC')->paginate();
        $lastChecks = UrlCheck::all()->keyBy('url_id');
        return view(
            'urls.index',
            compact('urls', 'lastChecks')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UrlPostRequest $request
     * @return RedirectResponse
     */
    public function store(UrlPostRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $name = $data['url']['name'];
        $existedName = Url::query()->where('name', $name)->first();
        if (is_null($existedName)) {
            $newData = [
                'name' => strtolower($name)
            ];
            $newUrl = Url::create($newData);
            $id = $newUrl->id;
            flash('Страница успешно добавлена')->success();
        } else {
            $id = $existedName->id;
            flash('Страница уже существует')->info();
        }
        return redirect()->route('urls.show', ['url' => $id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $url = Url::query()->findOrFail($id);
        $urlChecks = $url->getAttribute('urlChecks')->sortDesc();
        return view(
            'urls.show',
            compact('url', 'urlChecks')
        );
    }
}
