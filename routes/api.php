<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('ufv', \App\Http\Controllers\UfvController::class);
Route::apiResource('dolar', \App\Http\Controllers\DolarController::class);
Route::apiResource('dolar-ref', \App\Http\Controllers\DolarRefController::class);
