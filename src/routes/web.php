<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', function() {
    return view('reformas.home');
});

Route::resource('blog', BlogController::class);

