<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CotizacionController extends Controller
{
    // Método para la API: devuelve JSON
    public function convertir(Request $request)
    {
        $request->validate([
            'valor' => 'required|numeric',
            'tipo' => 'nullable|string'
        ]);

        $valorUSD = $request->query('valor');
        $tipo = $request->query('tipo', 'oficial');

        $cotizacion = $this->obtenerCotizacion($tipo);
        if (!$cotizacion) {
            return response()->json(['error' => 'Cotización no disponible.'], 500);
        }

        $resultado = $valorUSD * $cotizacion;

        return response()->json([
            'tipo' => $tipo,
            'valor_dolar' => $valorUSD,
            'cotizacion' => $cotizacion,
            'resultado_en_pesos' => round($resultado, 2)
        ]);
    }

    // Mostrar formulario web
    public function formulario()
    {
        return view('cotizar.cotizar');
    }

    // Procesar formulario web
    public function procesar(Request $request)
    {
        $request->validate([
            'valor' => 'required|numeric',
            'tipo' => 'nullable|string'
        ]);

        $valorUSD = $request->input('valor');
        $tipo = $request->input('tipo', 'oficial');

        $cotizacion = $this->obtenerCotizacion($tipo);
        if (!$cotizacion) {
            return back()->withErrors(['api' => 'Cotización no disponible.']);
        }

        $resultado = $valorUSD * $cotizacion;

        return view('cotizar.resultado', [
            'tipo' => $tipo,
            'valor_dolar' => $valorUSD,
            'cotizacion' => $cotizacion,
            'resultado_en_pesos' => round($resultado, 2)
        ]);
    }

    // Método privado para obtener la cotización desde la API
    private function obtenerCotizacion(string $tipo)
    {
        $baseUrl = config('services.dolarapi.url');
        $response = Http::get("{$baseUrl}/{$tipo}");

        if ($response->failed()) {
            return null;
        }

        return $response->json()['venta'] ?? null;
    }
}
