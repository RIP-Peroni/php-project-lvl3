<?php

namespace App\Http\Controllers;

use App\Models\UrlCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //todo убрать

class UrlCheckController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
//        $newCheck = UrlCheck::create();
          $url = DB::table('urls')->find($id); //todo использовать связи моделей для обращения к урлу
          dd($url);
        return redirect()->route('urls.show', compact('id'))
            ->with('success', 'Url created successfully');
    }

}
