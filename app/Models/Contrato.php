<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cliente_id',
        'fecha_inicio',
        'fecha_fin',
        'monto',
        'tipo',
        'activo',
    ];

    /**
     * Un Contrato pertenece a un Cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}