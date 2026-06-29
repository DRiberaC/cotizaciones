<?php

use Illuminate\Support\Facades\Route;
use App\Models\Ufv;
use App\Models\Dolar;

Route::get('/', function () {
    $today = today()->toDateString();
    
    $todayUfv = Ufv::where('fecha', $today)->first() ?? Ufv::orderBy('fecha', 'desc')->first();
    $todayDolar = Dolar::where('fecha', $today)->first() ?? Dolar::orderBy('fecha', 'desc')->first();
    
    $historicalUfvs = Ufv::orderBy('fecha', 'desc')->take(10)->get();
    $historicalDolars = Dolar::orderBy('fecha', 'desc')->take(10)->get();

    return view('api', compact('todayUfv', 'todayDolar', 'historicalUfvs', 'historicalDolars'));
});
