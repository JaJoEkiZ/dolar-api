<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Cotizacion;
use Illuminate\Support\Facades\DB;


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

        // 🔹 Guardamos la consulta en la DB
        $registro = Cotizacion::create([
            'moneda_origen' => 'USD',
            'moneda_destino' => 'ARS',
            'tasa' => $cotizacion,
            'respuesta_completa' => [
                'tipo' => $tipo,
                'valor_usd' => $valorUSD,
                'resultado_en_pesos' => round($resultado, 2),
            ],
        ]);

        return response()->json([
            'tipo' => $tipo,
            'valor_dolar' => $valorUSD,
            'cotizacion' => $cotizacion,
            'resultado_en_pesos' => round($resultado, 2),
            'registro_id' => $registro->id
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

    public function listarPorFecha(Request $request)
    {
    $request->validate([
        'inicio' => 'nullable|date',
        'fin' => 'nullable|date',
    ]);

    $fecha_inicio = $request->query('inicio');
    $fecha_fin = $request->query('fin');

    $query = Cotizacion::query();

    if ($fecha_inicio) {
        $query->whereDate('created_at', '>=', $fecha_inicio);
    }

    if ($fecha_fin) {
        $query->whereDate('created_at', '<=', $fecha_fin);
    }

    $cotizaciones = $query->orderBy('created_at', 'asc')->get();

    return response()->json([
        'cantidad' => $cotizaciones->count(),
        'cotizaciones' => $cotizaciones
    ]);
    }

    //calcular el promedio mensual

    public function promedioPorMes(Request $request)
    {
        $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'nullable|integer|min:2000',
        ]);

        $mes = $request->query('mes');
        $anio = $request->query('anio', now()->year); // Si no pasa año, toma el actual

        $data = DB::table('cotizacions')
            ->selectRaw("YEAR(created_at) as anio, MONTH(created_at) as mes, ROUND(AVG(tasa), 2) as promedio")
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $anio)
            ->groupBy('anio', 'mes')
            ->first(); // solo devuelve el promedio del mes

        return response()->json($data);
    }


    //promedio mensual por tipo

    public function promedioPorTipoYMes(Request $request)
    {
        $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'nullable|integer|min:2000',
        ]);

        $mes = $request->query('mes');
        $anio = $request->query('anio', now()->year);

        $data = DB::table('cotizacions')
            ->selectRaw("
                JSON_UNQUOTE(JSON_EXTRACT(respuesta_completa, '$.tipo')) as tipo,
                YEAR(created_at) as anio,
                MONTH(created_at) as mes,
                ROUND(AVG(tasa),2) as promedio
            ")
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $anio)
            ->groupBy('tipo', 'anio', 'mes')
            ->get();

        return response()->json($data);
    }


}
