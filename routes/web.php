<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomePageController::class, 'home'])->name('home');

//Route::resources([
//    'urls' => \App\Http\Controllers\UrlController::class,
////    'url_checks' => \App\Http\Controllers\UrlCheckController::class,
//]);

//Route::post('/urls/{id}/checks', [\App\Http\Controllers\UrlCheckController::class, 'store'])->name('check_process');

Route::resource('urls', \App\Http\Controllers\UrlController::class)->only('index', 'store', 'show');
Route::resource('url.checks', \App\Http\Controllers\UrlCheckController::class)->only('store');
