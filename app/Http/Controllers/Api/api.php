<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use Illuminate\Http\Request;

class api extends Controller
{
    public function getRecords(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $equipos = Equipo::with('cliente')
            ->whereBetween('fecha_recepcion', [$fechaInicio, $fechaFin])
            ->get();

        $totalReceivable = $equipos->sum('monto_pagar');
        //Log::info('totalReceivable - '.$totalReceivable);

        $highestDebtClient = $equipos->sortByDesc('monto_pagar')->first();
        //Log::info('highestDebtClient - '.$highestDebtClient);

        return response()->json([
            'items' => $equipos->map(function ($equipo) {
                return [
                    'id' => $equipo->id,
                    'tipo_equipo' => $equipo->tipo_equipo,
                    'marca_equipo' => $equipo->marca_equipo,
                    'modelo_equipo' => $equipo->modelo_equipo,
                    'fecha_recepcion' => $equipo->fecha_recepcion,
                    'valor_reparacion' => $equipo->monto_pagar,
                    'cliente' => $equipo->cliente,
                ];
            }),
            'totalReceivable' => $totalReceivable,
            'highestDebtClient' => $highestDebtClient ? $highestDebtClient->cliente->nombre : null,
        ]);
    }
}
