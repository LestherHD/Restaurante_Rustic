<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receta extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'version',
        'observaciones',
        'plato_id',
        'estado'
    ];

    protected $casts = [
        'version' => 'integer',
        'estado' => 'boolean'
    ];

    // Relaciones
    public function plato()
    {
        return $this->belongsTo(Plato::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetalleReceta::class);
    }
}
