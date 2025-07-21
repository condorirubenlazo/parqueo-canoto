<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cliente;
use App\Models\Vehiculo;
use App\Models\Contrato;
use App\Models\RegistroParqueo;
use Carbon\Carbon;

class ParqueoController extends Controller
{
    public function index()
    {
        // Definimos la capacidad total del parqueo. Puedes ajustar este valor.
        $totalEspacios = 200; 

        // Obtenemos los vehículos que están actualmente dentro
        $vehiculos_dentro = RegistroParqueo::whereNull('fecha_hora_salida')
                                          ->orderBy('fecha_hora_ingreso', 'desc')
                                          ->get();

        // Calculamos los espacios ocupados y disponibles
        $espaciosOcupados = $vehiculos_dentro->count();
        $espaciosDisponibles = $totalEspacios - $espaciosOcupados;

        // Pasamos todas las variables a la vista
        return view('parqueo.index', compact(
            'vehiculos_dentro', 
            'totalEspacios', 
            'espaciosOcupados', 
            'espaciosDisponibles'
        ));
    }

    public function registrarIngreso(Request $request)
    {
        $validator = Validator::make($request->all(), ['placa' => 'required|string|max:10']);
        if ($validator->fails()) { return redirect()->route('parqueo.index')->withErrors($validator)->withInput(); }
        $placa = strtoupper($request->input('placa'));

        if (RegistroParqueo::where('placa', $placa)->whereNull('fecha_hora_salida')->exists()) {
            return redirect()->route('parqueo.index')->with('error', "¡Error! El vehículo con placa $placa ya se encuentra dentro del parqueo.");
        }

        $vehiculo = Vehiculo::with('cliente')->where('placa', $placa)->first();

        if ($vehiculo) {
            $cliente = $vehiculo->cliente;
            $tipoCliente = $cliente->tipo;
            if ($tipoCliente === 'abonado' || $tipoCliente === 'abonado_vip') {
                $contratoActivo = Contrato::where('cliente_id', $cliente->id)->where('activo', true)->where('fecha_fin', '>=', now()->toDateString())->first();
                if (!$contratoActivo) {
                    return redirect()->route('parqueo.index')->with('error', "Abono vencido para $cliente->nombre. Debe renovar o pagar como visitante.");
                }
            }
            $registro = $this->crearRegistroParqueo($placa, $tipoCliente);
            return view('parqueo.ticket_ingreso', compact('registro'));
        } else {
            if (!$request->has('marca')) {
                return view('parqueo.registrar_visitante', ['placa' => $placa]);
            } else {
                $clienteVisitante = Cliente::firstOrCreate(['ci' => '0'], ['nombre' => 'Cliente', 'apellido' => 'Visitante', 'tipo' => 'visitante']);
                Vehiculo::create([
                    'cliente_id' => $clienteVisitante->id, 'placa' => $placa, 'marca' => $request->input('marca'),
                    'modelo' => $request->input('modelo'), 'color' => $request->input('color'),
                ]);
                $registro = $this->crearRegistroParqueo($placa, 'visitante');
                return view('parqueo.ticket_ingreso', compact('registro'));
            }
        }
    }
    
    public function registrarSalida(Request $request)
    {
        $validator = Validator::make($request->all(), ['placa' => 'required|string|max:10']);
        if ($validator->fails()) { return redirect()->route('parqueo.index')->withErrors($validator)->withInput(); }
        $placa = strtoupper($request->input('placa'));
        $registro = RegistroParqueo::where('placa', $placa)->whereNull('fecha_hora_salida')->first();

        if (!$registro) {
            return redirect()->route('parqueo.index')->with('error', "El vehículo con placa $placa no se encuentra registrado dentro del parqueo.");
        }

        // --- FLUJO MODIFICADO PARA ABONADOS ---
        if ($registro->tipo_cliente === 'abonado' || $registro->tipo_cliente === 'abonado_vip') {
            $registro->fecha_hora_salida = now();
            $registro->save();
            
            // Buscamos los datos del cliente y su contrato para pasarlos a la vista del ticket
            $vehiculo = Vehiculo::with('cliente')->where('placa', $placa)->first();
            $cliente = $vehiculo ? $vehiculo->cliente : null;
            $contrato = null;
            if ($cliente) {
                $contrato = Contrato::where('cliente_id', $cliente->id)->where('activo', true)->first();
            }

            // Mostramos la nueva vista del ticket de salida para abonados
            return view('parqueo.ticket_salida_abonado', compact('registro', 'cliente', 'contrato'));
        }

        // --- FLUJO PARA VISITANTES (sin cambios) ---
        if ($registro->tipo_cliente === 'visitante') {
            $horaIngreso = Carbon::parse($registro->fecha_hora_ingreso);
            $horaSalida = now();
            $minutosTranscurridos = $horaSalida->diffInMinutes($horaIngreso);
            $montoACobrar = 5;
            if ($minutosTranscurridos > 60) {
                $horasAdicionales = ceil(($minutosTranscurridos - 60) / 60);
                $montoACobrar += $horasAdicionales * 3;
            }
            $registro->fecha_hora_salida = $horaSalida;
            $registro->monto_cobrado = $montoACobrar;
            $registro->save();
            $tiempoEstadia = $horaIngreso->diffForHumans($horaSalida, true);
            return view('parqueo.ticket', compact('registro', 'tiempoEstadia'));
        }
        return redirect()->route('parqueo.index')->with('error', 'Ocurrió un error inesperado.');
    }

    private function crearRegistroParqueo(string $placa, string $tipo_cliente)
    {
        $espacio = $this->asignarEspacio($tipo_cliente);
        return RegistroParqueo::create([
            'placa' => $placa,
            'fecha_hora_ingreso' => now(),
            'tipo_cliente' => $tipo_cliente,
            'espacio_asignado' => $espacio,
        ]);
    }

    private function asignarEspacio(string $tipoCliente): string
    {
        if ($tipoCliente === 'abonado_vip') {
            $piso = 1; $letra = 'A';
        } else {
            $piso = rand(2, 5); $letra = chr(rand(65, 70));
        }
        $numero = rand(1, 50);
        return "P{$piso}-{$letra}" . str_pad($numero, 2, '0', STR_PAD_LEFT);
    }
}