<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class CotizacionController extends Controller
{
 public function convertir(Request $request)
 {
 $valorUSD = $request->query('valor');
 $tipo = $request->query('tipo', 'oficial'); // Por defecto usamos "oficial"
 if (!$valorUSD || !is_numeric($valorUSD)) {
 return response()->json(['error' => 'Debe enviar un valor numérico en
dólares.'], 400);
 }
 // Obtener la URL base desde config/services.php
 $baseUrl = config('services.dolarapi.url');
 // Consumir la API externa
 $response = Http::get("{$baseUrl}/{$tipo}");
 if ($response->failed()) {
 return response()->json(['error' => 'No se pudo obtener la cotización.'],
500);
 }
 $data = $response->json();
 $cotizacion = $data['venta'] ?? null;
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

 // Formulario
    public function formulario()
    {
        return view('cotizar/cotizar');
    }

    // Procesar formulario
    public function procesar(Request $request)
    {
        $valorUSD = $request->input('valor');
        $tipo = $request->input('tipo', 'oficial');

        if (!$valorUSD || !is_numeric($valorUSD)) {
            return back()->withErrors(['valor' => 'Debe ingresar un valor numérico en dólares.']);
        }

        $baseUrl = config('services.dolarapi.url');
        $response = Http::get("{$baseUrl}/{$tipo}");

        if ($response->failed()) {
            return back()->withErrors(['api' => 'No se pudo obtener la cotización.']);
        }

        $data = $response->json();
        $cotizacion = $data['venta'] ?? null;

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
}