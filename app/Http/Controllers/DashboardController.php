<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrato;
use App\Models\RegistroParqueo;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // --- 1. DATOS PARA TARJETAS DE KPIs ---

        // Ingresos totales del mes actual (sumando contratos y registros de visitantes)
        $ingresosContratosMes = Contrato::whereYear('created_at', now()->year)
                                        ->whereMonth('created_at', now()->month)
                                        ->sum('monto');

        $ingresosVisitantesMes = RegistroParqueo::where('tipo_cliente', 'visitante')
                                                ->whereNotNull('monto_cobrado')
                                                ->whereYear('fecha_hora_salida', now()->year)
                                                ->whereMonth('fecha_hora_salida', now()->month)
                                                ->sum('monto_cobrado');
        
        $ingresosTotalesMes = $ingresosContratosMes + $ingresosVisitantesMes;

        // Número de abonados activos
        $abonadosActivos = Contrato::where('activo', true)
                                   ->where('fecha_fin', '>=', now()->toDateString())
                                   ->count();

        // Total de clientes registrados (excluyendo al genérico)
        $totalClientes = Cliente::where('ci', '!=', '0')->count();


        // --- 2. DATOS PARA GRÁFICO DE INGRESOS DIARIOS (ÚLTIMOS 7 DÍAS) ---
        $ingresosDiarios = RegistroParqueo::where('tipo_cliente', 'visitante')
            ->whereNotNull('monto_cobrado')
            ->where('fecha_hora_salida', '>=', now()->subDays(7))
            ->groupBy(DB::raw('DATE(fecha_hora_salida)'))
            ->select(DB::raw('DATE(fecha_hora_salida) as fecha'), DB::raw('SUM(monto_cobrado) as total'))
            ->pluck('total', 'fecha');
        
        // Formatear datos para Chart.js
        $labelsIngresosDiarios = [];
        $dataIngresosDiarios = [];
        for ($i = 6; $i >= 0; $i--) {
            $fecha = now()->subDays($i)->format('Y-m-d');
            $labelsIngresosDiarios[] = Carbon::parse($fecha)->format('D, d M'); // ej. "Lun, 15 Jul"
            $dataIngresosDiarios[] = $ingresosDiarios->get($fecha, 0); // Si no hay ingresos, pone 0
        }

        // --- 3. DATOS PARA GRÁFICO DE TIPOS DE CLIENTE (ACTIVOS) ---
        $tiposClienteData = Cliente::where('tipo', '!=', 'visitante')
                                   ->whereHas('contratos', function($query) {
                                       $query->where('activo', true);
                                   })
                                   ->select('tipo', DB::raw('count(*) as total'))
                                   ->groupBy('tipo')
                                   ->pluck('total', 'tipo');
        
        $labelsTiposCliente = $tiposClienteData->keys()->map(function($tipo){
            return ucfirst(str_replace('_', ' ', $tipo)); // 'abonado_vip' -> 'Abonado Vip'
        });
        $dataTiposCliente = $tiposClienteData->values();
        
        // Pasamos todos los datos a la vista
        return view('dashboard.index', compact(
            'ingresosTotalesMes',
            'abonadosActivos',
            'totalClientes',
            'labelsIngresosDiarios',
            'dataIngresosDiarios',
            'labelsTiposCliente',
            'dataTiposCliente'
        ));
    }
}