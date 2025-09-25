<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cotizacion;
use Illuminate\Support\Carbon;

class CotizacionSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = ['oficial', 'blue', 'tarjeta'];
        $fecha_inicio = Carbon::createFromDate(now()->year, 1, 1);
        $fecha_fin = Carbon::now();

        $dias = $fecha_inicio->diffInDays($fecha_fin);

        for ($i = 0; $i <= $dias; $i++) {
            $fecha = $fecha_inicio->copy()->addDays($i);

            foreach ($tipos as $tipo) {
                // Generamos un valor de tasa simulado según el tipo
                switch ($tipo) {
                    case 'oficial':
                        $tasa = rand(9000, 9500) / 10; // 900-950
                        break;
                    case 'blue':
                        $tasa = rand(15000, 16000) / 10; // 1500-1600
                        break;
                    case 'tarjeta':
                        $tasa = rand(14000, 15000) / 10; // 1400-1500
                        break;
                }

                Cotizacion::create([
                    'moneda_origen' => 'USD',
                    'moneda_destino' => 'ARS',
                    'tasa' => $tasa,
                    'respuesta_completa' => [
                        'tipo' => $tipo,
                        'valor_usd' => 100,
                        'resultado_en_pesos' => round($tasa * 100, 2),
                    ],
                    'created_at' => $fecha,
                    'updated_at' => $fecha,
                ]);
            }
        }
    }
}
