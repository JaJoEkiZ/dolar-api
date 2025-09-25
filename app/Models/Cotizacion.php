<?php

namespace App\Models;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cotizacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'moneda_origen',
        'moneda_destino',
        'tasa',
        'respuesta_completa',
    ];

    // Si querés que el JSON siempre se devuelva como array
    protected $casts = [
        'respuesta_completa' => 'array',
    ];
}
