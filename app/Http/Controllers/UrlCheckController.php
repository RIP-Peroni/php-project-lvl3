<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\UrlCheck;
use Illuminate\Http\RedirectResponse;

class UrlCheckController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function store($id): RedirectResponse
    {
//        $newCheck = UrlCheck::create();
//        $url = Url::findOrFail($id);
        $data = ['url_id' => $id];
        $newCheck = new UrlCheck();
        $newCheck->fill($data);
        $newCheck->save();
        return redirect()->route('urls.show', ['url' => $id])
            ->with('success', 'Url checked successfully');
    }

}
