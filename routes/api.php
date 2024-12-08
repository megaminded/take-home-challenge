<?php

use App\Services\NewsAPI;
use App\Services\NewYorkTimes;
use App\Services\TheGuardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/all', function () {
    // $news = new NewsAPI();
    $news = new TheGuardian();
    // $news = new NewYorkTimes();
    $news->fetch();
});
