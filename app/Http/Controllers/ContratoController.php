<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContratoController extends Controller
{
    /**
     * Muestra el formulario para crear un nuevo contrato para un cliente.
     */
    public function create(Cliente $cliente)
    {
        return view('contratos.create', compact('cliente'));
    }

    /**
     * Guarda un nuevo contrato y muestra el recibo de pago.
     */
    public function store(Request $request, Cliente $cliente)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'tipo' => 'required|in:abonado,abonado_vip'
        ]);

        // Desactiva todos los contratos anteriores de este cliente.
        Contrato::where('cliente_id', $cliente->id)->update(['activo' => false]);

        $fecha_inicio = Carbon::parse($request->input('fecha_inicio'));
        $fecha_fin = $fecha_inicio->copy()->addMonthNoOverflow();
        $monto = ($request->input('tipo') === 'abonado_vip') ? 400 : 200;

        // Creación del nuevo contrato y lo guardamos en una variable
        $contrato = Contrato::create([
            'cliente_id' => $cliente->id,
            'fecha_inicio' => $fecha_inicio->toDateString(),
            'fecha_fin' => $fecha_fin->toDateString(),
            'monto' => $monto,
            'tipo' => $request->input('tipo'),
            'activo' => true,
        ]);

        // Nos aseguramos que el tipo de cliente coincida con su último contrato
        $cliente->tipo = $request->input('tipo');
        $cliente->save();

        // ** EL CAMBIO CLAVE ESTÁ AQUÍ **
        // En lugar de redirigir, mostramos la vista del recibo con los datos.
        return view('contratos.recibo_contrato', compact('cliente', 'contrato'));
    }

    /**
     * Elimina un contrato de la base de datos.
     */
    public function destroy(Contrato $contrato)
    {
        $cliente = $contrato->cliente;
        $contrato->delete();
        return redirect()->route('clientes.show', $cliente)->with('success', 'Contrato eliminado exitosamente.');
    }
}