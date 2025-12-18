<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('ufv/obtener-day/{fecha}', [\App\Http\Controllers\UfvController::class, 'getByDay']);
Route::get('ufv/obtener-month/{yearMonth}', [\App\Http\Controllers\UfvController::class, 'getByMonth']);
Route::get('ufv/obtener-year/{year}', [\App\Http\Controllers\UfvController::class, 'getByYear']);

Route::get('dolar/obtener-day/{fecha}', [\App\Http\Controllers\DolarController::class, 'getByDay']);
Route::get('dolar/obtener-month/{yearMonth}', [\App\Http\Controllers\DolarController::class, 'getByMonth']);
Route::get('dolar/obtener-year/{year}', [\App\Http\Controllers\DolarController::class, 'getByYear']);

Route::get('dolar-ref/obtener-day/{fecha}', [\App\Http\Controllers\DolarRefController::class, 'getByDay']);
Route::get('dolar-ref/obtener-month/{yearMonth}', [\App\Http\Controllers\DolarRefController::class, 'getByMonth']);
Route::get('dolar-ref/obtener-year/{year}', [\App\Http\Controllers\DolarRefController::class, 'getByYear']);

Route::apiResource('ufv', \App\Http\Controllers\UfvController::class);
Route::apiResource('dolar', \App\Http\Controllers\DolarController::class);
Route::apiResource('dolar-ref', \App\Http\Controllers\DolarRefController::class);
