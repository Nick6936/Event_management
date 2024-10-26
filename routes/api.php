<?php

use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::apiResource('/events', EventController::class);
Route::apiResource('/attendees', AttendeeController::class);
Route::apiResource('/categories', CategoryController::class);
