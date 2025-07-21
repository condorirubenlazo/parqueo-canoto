<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehiculoController extends Controller
{
    /**
     * Muestra el formulario para crear un nuevo vehículo para un cliente específico.
     */
    public function create(Cliente $cliente)
    {
        return view('vehiculos.create', compact('cliente'));
    }

    /**
     * Guarda un nuevo vehículo en la base de datos, asociado a un cliente.
     */
    public function store(Request $request, Cliente $cliente)
    {
        $request->validate([
            'placa' => 'required|string|max:10|unique:vehiculos,placa',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'color' => 'required|string|max:50',
        ]);

        $vehiculo = new Vehiculo($request->all());
        $cliente->vehiculos()->save($vehiculo);

        return redirect()->route('clientes.show', $cliente)->with('success', 'Vehículo registrado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un vehículo existente.
     */
    public function edit(Vehiculo $vehiculo)
    {
        // El cliente se puede obtener a través de la relación del vehículo
        $cliente = $vehiculo->cliente; 
        return view('vehiculos.edit', compact('vehiculo', 'cliente'));
    }

    /**
     * Actualiza un vehículo específico en la base de datos.
     */
    public function update(Request $request, Vehiculo $vehiculo)
    {
        $request->validate([
            'placa' => ['required', 'string', 'max:10', Rule::unique('vehiculos')->ignore($vehiculo->id)],
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'color' => 'required|string|max:50',
        ]);

        $vehiculo->update($request->all());

        // Redirigimos a la vista de detalles del cliente al que pertenece el vehículo
        return redirect()->route('clientes.show', $vehiculo->cliente_id)->with('success', 'Vehículo actualizado exitosamente.');
    }

    /**
     * Elimina un vehículo específico.
     */
    public function destroy(Vehiculo $vehiculo)
    {
        $cliente = $vehiculo->cliente;
        $vehiculo->delete();

        return redirect()->route('clientes.show', $cliente)->with('success', 'Vehículo eliminado exitosamente.');
    }
}