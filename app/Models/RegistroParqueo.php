<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroParqueo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'registros_parqueo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'placa',
        'fecha_hora_ingreso',
        'fecha_hora_salida',
        'monto_cobrado',
        'tipo_cliente',
        'espacio_asignado',
    ];
}