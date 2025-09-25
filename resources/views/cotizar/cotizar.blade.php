@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow rounded">
    <h1 class="text-2xl font-bold mb-4">Convertir dólares a pesos</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('cotizar.procesar') }}" class="space-y-4">
        @csrf
        <div>
            <label for="valor" class="block font-semibold">Valor en USD:</label>
            <input type="text" name="valor" id="valor"
                class="border rounded w-full p-2" value="{{ old('valor') }}">
        </div>

        <div>
            <label for="tipo" class="block font-semibold">Tipo de dólar:</label>
            <select name="tipo" id="tipo" class="border rounded w-full p-2">
                <option value="oficial">Oficial</option>
                <option value="blue">Blue</option>
                <option value="mep">MEP</option>
                <option value="ccl">CCL</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Convertir
        </button>
    </form>
</div>
@endsection
