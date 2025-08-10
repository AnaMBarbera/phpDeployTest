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

Route::get('/debug/publicpath', function () {
    return public_path('ruta.php');
});
