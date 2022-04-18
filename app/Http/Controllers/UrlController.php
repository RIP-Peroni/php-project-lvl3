<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlPostRequest;
use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $urls = Url::orderBy('created_at', 'ASC')->paginate(5);
        return view(
            'urls.index',
            compact('urls')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UrlPostRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UrlPostRequest $request)
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = Url::findOrFail($id);
        return view('urls.show', compact('url'));
    }
}
