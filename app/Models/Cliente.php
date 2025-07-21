<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', // <-- CAMPO AÑADIDO
        'nombre',
        'apellido',
        'ci',
        'telefono',
        'tipo',
    ];

    /**
     * Un Cliente puede tener muchos Vehiculos.
     */
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }

    /**
     * Un Cliente puede tener muchos Contratos (historial).
     */
    public function contratos()
    {
        return $this->hasMany(Contrato::class);
    }

    /**
     * FUNCIÓN AÑADIDA:
     * Obtiene la cuenta de usuario asociada a este cliente (si existe).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}