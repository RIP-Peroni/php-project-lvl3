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
        $urls = Url::orderBy('created_at', 'ASC')->paginate(3);
        return view(
            'urls.index',
            compact('urls')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
