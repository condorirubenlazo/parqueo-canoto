<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contrato;

class PortalController extends Controller
{
    /**
     * Muestra el portal del cliente con su información relevante.
     */
    public function index()
    {
        // Obtenemos el usuario autenticado
        $user = Auth::user();

        // A través de la relación que creamos, obtenemos el perfil de cliente
        $cliente = $user->cliente;
        
        // Si por alguna razón el usuario no tiene un perfil de cliente asociado,
        // lo redirigimos con un error para que el admin lo solucione.
        if (!$cliente) {
            Auth::logout(); // Deslogueamos para evitar bucles
            return redirect()->route('login')->with('error', 'Tu cuenta de usuario no está vinculada a un perfil de cliente. Contacta al administrador.');
        }

        // Cargamos las relaciones que necesitamos mostrar en el portal
        $cliente->load('vehiculos');

        // Buscamos el contrato activo del cliente para mostrar su estado
        $contratoActivo = Contrato::where('cliente_id', $cliente->id)
                                  ->where('activo', true)
                                  ->first();

        // Pasamos toda la información a la vista
        return view('cliente.portal', compact('user', 'cliente', 'contratoActivo'));
    }
}