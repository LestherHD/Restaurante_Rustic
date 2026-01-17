<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleReceta extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tipo',
        'cantidad',
        'receta_id',
        'ingrediente_id',
        'subreceta_id',
        'estado'
    ];

    protected $attributes = [
        'tipo' => 'ingrediente',
        'estado' => true
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'estado' => 'boolean'
    ];

    // Relaciones
    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }

    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class);
    }

    public function subreceta()
    {
        return $this->belongsTo(Receta::class, 'subreceta_id');
    }
}
