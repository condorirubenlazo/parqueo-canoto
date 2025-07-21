<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::where('ci', '!=', '0')->with('user')->orderBy('apellido')->get();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        $usuarios_disponibles = User::where('role', 'cliente')
                                    ->whereDoesntHave('cliente')
                                    ->get();
        return view('clientes.create', compact('usuarios_disponibles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'ci' => 'required|string|unique:clientes,ci|max:20',
            'telefono' => 'nullable|string|max:20',
            // LÍNEA MODIFICADA: Se añade 'visitante' a la lista de valores permitidos.
            'tipo' => 'required|in:visitante,abonado,abonado_vip',
            'user_id' => 'nullable|exists:users,id'
        ]);
        
        Cliente::create($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function show(Cliente $cliente)
    {
        $cliente->load('vehiculos', 'contratos', 'user');
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        $usuarios_disponibles = User::where('role', 'cliente')
                                    ->where(function ($query) use ($cliente) {
                                        $query->whereDoesntHave('cliente')
                                              ->orWhere('id', $cliente->user_id);
                                    })->get();
        return view('clientes.edit', compact('cliente', 'usuarios_disponibles'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'ci' => ['required', 'string', 'max:20', Rule::unique('clientes')->ignore($cliente->id)],
            'telefono' => 'nullable|string|max:20',
            // LÍNEA MODIFICADA: Se añade 'visitante' a la lista de valores permitidos.
            'tipo' => 'required|in:visitante,abonado,abonado_vip',
            'user_id' => 'nullable|exists:users,id'
        ]);
        
        $cliente->update($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
    }
}