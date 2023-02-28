<?php

use App\Http\Controllers\Commentcontroller;
use App\Http\Controllers\Postcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(Postcontroller::class)->group(function () {
    Route::get('posts', 'index');
    Route::get('posts/{post}', 'show');
    Route::post('posts', 'store');
    Route::patch('posts/{post}', 'update');
    Route::delete('posts/{post}', 'destroy');
});

Route::controller(Commentcontroller::class)->group(function () {
    Route::get('comments', 'index');
    Route::get('comments/{comment}', 'show');
    Route::post('comments', 'store');
    Route::patch('comments/{comment}', 'update');
    Route::delete('comments/{comment}', 'destroy');
});
