<?php

use App\Http\Controllers\Api\NewsController;
use App\Services\NewsAPI;
use App\Services\NewYorkTimes;
use App\Services\TheGuardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('news')->group(function () {
    /**  */
    Route::get('/index', [NewsController::class, 'index']);

    /** Returns news based on search query */
    Route::post('/search', [NewsController::class, 'search']);

    /** Returns news based on selected category */
    Route::get('/category/{category}', [NewsController::class, 'category']);

    /** Returns news based on selected source */
    Route::get('/source/{source}', [NewsController::class, 'source']);

    /** Returns news based on selected date */
    Route::post('/date', [NewsController::class, 'date']);
});
