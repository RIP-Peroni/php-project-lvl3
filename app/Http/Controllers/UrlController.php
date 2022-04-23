<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $urls = DB::table('urls')->paginate();
        $lastChecks = DB::table('url_checks')
            ->orderBy('url_id')
            ->latest()
            ->distinct('url_id')
            ->get()
            ->keyBy('url_id');
        return view(
            'urls.index',
            compact('urls', 'lastChecks')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UrlRequest $request
     * @return RedirectResponse
     */
    public function store(UrlRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $name = $data['url']['name'];
        $existedName = DB::table('urls')->where('name', $name)->first();
        if (is_null($existedName)) {
            $newData = [
                'name' => strtolower($name),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
            $id = DB::table('urls')->insertGetId($newData);
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
     * @param int $id
     * @return Application|Factory|View
     */
    public function show(int $id)
    {
        $url = DB::table('urls')->find($id);
        $urlChecks = DB::table('url_checks')
            ->where('url_id', $id)
            ->latest()
            ->get();
        return view(
            'urls.show',
            compact('url', 'urlChecks')
        );
    }
}
