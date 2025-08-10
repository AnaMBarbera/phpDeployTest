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

Route::resource('blog', BlogController::class)->except(['edit', 'update']);
Route::get('blog/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');
Route::put('blog/{id}', [BlogController::class, 'update'])->name('blog.update');




Route::get('/debug/publicpath', function () {
    return public_path('ruta.php');
});
