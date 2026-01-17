<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidoProducto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cantidad',
        'precio_unitario',
        'pedido_id',
        'plato_id'
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2'
    ];

    // Relaciones
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function plato()
    {
        return $this->belongsTo(Plato::class);
    }

    // Métodos helper
    public function getSubtotalAttribute()
    {
        return $this->cantidad * $this->precio_unitario;
    }
}
