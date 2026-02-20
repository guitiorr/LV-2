<?php

use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\NewsController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiAuthController::class, 'login']);
Route::get('/news', [NewsController::class, 'getAllNews']);
Route::post('/insert-news', [NewsController::class, 'insertNews']);
