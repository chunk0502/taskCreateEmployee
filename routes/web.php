<?php

use App\Http\Controllers\Blog\BlogController;
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
//Route::get('/', function(){
//    return view('public.layouts.post');
//});

// Route::controller(App\Http\Controllers\Auth\ResetPasswordController::class)
// ->prefix('/reset-password')
// ->as('password.reset.')
// ->group(function(){
//     Route::get('/edit', 'edit')->name('edit')->middleware('signed');
//     Route::put('/update', 'update')->name('update');
//     Route::get('/success', 'success')->name('success');
// });
Route::prefix('/blog')
    ->name('post.')
    ->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('/{slug}', [BlogController::class, 'showPost'])->name('show');
    });
