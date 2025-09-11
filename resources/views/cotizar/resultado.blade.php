@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow rounded">
    <h1 class="text-2xl font-bold mb-4">Resultado de la conversión</h1>

    <div class="mb-4">
        <p><strong>Valor ingresado:</strong> {{ $valor_dolar }} USD</p>
        <p><strong>Tipo de dólar:</strong> {{ ucfirst($tipo) }}</p>
        <p><strong>Cotización:</strong> ${{ number_format($cotizacion, 2) }}</p>
        <p class="mt-2 text-xl font-bold">
            Resultado en pesos: ${{ number_format($resultado_en_pesos, 2) }}
        </p>
    </div>

    <a href="{{ route('cotizar.form') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
        Volver
    </a>
</div>
@endsection
