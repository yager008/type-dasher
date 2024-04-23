<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\MainController;
Route::get('/Hello', [MainController::class, 'index' ])->name('index');

Route::get('/test', fn() => view('test'));
