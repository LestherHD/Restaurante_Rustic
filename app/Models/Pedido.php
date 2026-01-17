<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'total',
        'estado_pedido_id',
        'mesa_id',
        'usuario_id'
    ];

    protected $casts = [
        'total' => 'decimal:2'
    ];

    // Relaciones
    public function estado()
    {
        return $this->belongsTo(EstadoPedido::class, 'estado_pedido_id');
    }

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function productos()
    {
        return $this->hasMany(PedidoProducto::class);
    }

    // Métodos helper
    public function calcularTotal()
    {
        $this->total = $this->productos()->sum(\DB::raw('cantidad * precio_unitario'));
        $this->save();
    }

    public function descontarInventario()
    {
        foreach ($this->productos as $producto) {
            $plato = $producto->plato;
            $receta = $plato->recetas()->where('estado', true)->first();

            if ($receta) {
                foreach ($receta->detalles as $detalle) {
                    if ($detalle->tipo === 'ingrediente' && $detalle->ingrediente) {
                        $cantidadTotal = $detalle->cantidad * $producto->cantidad;
                        $detalle->ingrediente->descontarStock($cantidadTotal);

                        // Registrar movimiento
                        MovimientoInventario::create([
                            'tipo_movimiento' => 'salida',
                            'cantidad' => $cantidadTotal,
                            'referencia_tipo' => 'pedido',
                            'comentario' => "Venta pedido #{$this->id} - {$plato->nombre}",
                            'fecha_movimiento' => now(),
                            'ingrediente_id' => $detalle->ingrediente->id
                        ]);
                    }
                }
            }
        }
    }
}
