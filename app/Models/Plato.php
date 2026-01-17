<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plato extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_venta',
        'costo_produccion',
        'visible_en_menu',
        'categoria_id',
        'activo'
    ];

    protected $casts = [
        'precio_venta' => 'decimal:2',
        'costo_produccion' => 'decimal:2',
        'visible_en_menu' => 'boolean',
        'activo' => 'boolean'
    ];

    // Relaciones
    public function categoria()
    {
        return $this->belongsTo(CategoriaMenu::class, 'categoria_id');
    }

    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }

    public function pedidoProductos()
    {
        return $this->hasMany(PedidoProducto::class);
    }

    // Métodos helper
    public function calcularCostoProduccion()
    {
        $receta = $this->recetas()->where('estado', true)->first();
        
        if (!$receta) {
            return 0;
        }

        $costo = 0;
        foreach ($receta->detalles as $detalle) {
            if ($detalle->tipo === 'ingrediente' && $detalle->ingrediente) {
                $costo += $detalle->cantidad * $detalle->ingrediente->costo_unitario;
            }
        }

        return $costo;
    }
}
