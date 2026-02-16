<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\EngineController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home');
// });

Route::get('/', [EngineController::class, 'show']);

Route::get('/new', function () {
    return view('new_engine_form');
});

Route::post('/new/engine', [EngineController::class, 'store']);

Route::delete('/delete/{id}', function ($id) {
    DB::delete('EXEC sp_DeleteEngine @Code = ?', [$id]);
    return redirect('/')->with('success', 'Engine deleted successfully.');
});

Route::get('/engine/{code}/edit', [EngineController::class, 'edit']);
Route::put('/engine/{code}', [EngineController::class, 'update']);

//LOGIN START

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', Login::class);

//LOGIN END

Route::post('/logout', Logout::class);
