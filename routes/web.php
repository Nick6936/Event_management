<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('register','register')->name('register');
Route::post('registerSave',[UserController::class,'register'])->name('registerSave');


Route::view('login', 'login')->name('login');
Route::post('loginMatch',[UserController::class,'login'])->name('loginMatch');

Route::get('dashboard',[UserController::class,'dashboardPage'])->name('dashboard');
Route::get('logout',[UserController::class,'logout'])->name('logout');

Route::get('/event', [PageController::class, 'event'])->name('event');
Route::get('/attendee', [PageController::class, 'attendee'])->name('attendee');
Route::get('/categories', [PageController::class, 'categories'])->name('categories');
