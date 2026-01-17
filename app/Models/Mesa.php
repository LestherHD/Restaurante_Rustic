<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mesa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'pos_x',
        'pos_y',
        'capacidad',
        'estado_mesa',
        'estado'
    ];

    protected $casts = [
        'pos_x' => 'integer',
        'pos_y' => 'integer',
        'capacidad' => 'integer',
        'estado' => 'boolean'
    ];

    // Relaciones
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    // Métodos helper
    public function estaLibre()
    {
        return $this->estado_mesa === 'libre';
    }

    public function ocupar()
    {
        $this->estado_mesa = 'ocupada';
        $this->save();
    }

    public function liberar()
    {
        $this->estado_mesa = 'libre';
        $this->save();
    }
}
