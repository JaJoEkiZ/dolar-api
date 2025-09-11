<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CotizacionController;

Route::get('/cotizar', [CotizacionController::class, 'formulario'])->name('cotizar.form');
Route::post('/cotizar', [CotizacionController::class, 'procesar'])->name('cotizar.procesar');

