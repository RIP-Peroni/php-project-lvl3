<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\UrlCheck;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DiDom\Document;

class HomePageController extends Controller
{
    public function home()
    {
        return view('welcome');
    }
}
