<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        // CAMBIO: Se usa get() en lugar de paginate().
        // DataTables se encargará de la paginación y la búsqueda.
        $usuarios = User::where('id', '!=', Auth::id())->get(); // <-- ESTA LÍNEA FUE CAMBIADA
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cajero',
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario Cajero creado exitosamente.');
    }

    /**
     * Muestra el formulario de edición para el usuario especificado.
     */
    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Actualiza el usuario especificado en la base de datos.
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($usuario->id)],
            'role' => ['required', 'string', Rule::in(['admin', 'cajero', 'cliente'])],
        ]);
        
        // Evitar que el admin se quite a sí mismo el rol de admin por accidente
        if ($usuario->id === Auth::id() && $request->role !== 'admin') {
            return back()->with('error', 'No puedes cambiar tu propio rol de administrador.');
        }

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $usuario)
    {
        if ($usuario->role === 'admin') {
            return redirect()->route('usuarios.index')->with('error', 'No se puede eliminar a un administrador.');
        }

        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}