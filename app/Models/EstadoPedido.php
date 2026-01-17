<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoPedido extends Model
{
    use SoftDeletes;

    protected $table = 'estados_pedidos';

    protected $fillable = [
        'nombre',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean'
    ];

    // Relaciones
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
