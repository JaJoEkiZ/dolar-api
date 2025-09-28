<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CotizacionController;

Route::get('/convertir', [CotizacionController::class, 'convertir']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/cotizaciones/rango', [CotizacionController::class, 'listarPorFecha']);

Route::get('/cotizaciones/promedio-por-mes', [CotizacionController::class, 'promedioPorMes']);
Route::get('/cotizaciones/promedio-por-tipo-y-mes', [CotizacionController::class, 'promedioPorTipoYMes']);


