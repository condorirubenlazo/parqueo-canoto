<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cliente_id',
        'placa',
        'marca',
        'modelo',
        'color',
    ];

    /**
     * Un Vehiculo pertenece a un Cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}