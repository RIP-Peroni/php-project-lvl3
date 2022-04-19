<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlPostRequest;
use App\Models\Url;
use App\Models\UrlCheck;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $urls = Url::orderBy('created_at', 'ASC')->paginate();
        $lastChecks = UrlCheck::all()->keyBy('url_id');
//        dd($lastChecks);
        return view(
            'urls.index',
            compact('urls', 'lastChecks')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UrlPostRequest  $request
     * @return RedirectResponse
     */
    public function store(UrlPostRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $name = $data['url']['name'];
        $newData = [
            'name' => strtolower($name)
        ];
        $newUrl = Url::create($newData);
        $id = $newUrl->id;
        return redirect()->route('urls.show', $id)
            ->with('success', 'Url created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $url = Url::findOrFail($id);
        $urlChecks = $url->urlChecks;
//        dd($urlChecks);
        return view(
            'urls.show',
            compact('url', 'urlChecks')
        );
    }
}
