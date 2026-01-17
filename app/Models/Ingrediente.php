<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingrediente extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'unidad_medida_id',
        'stock_actual',
        'stock_minimo',
        'costo_unitario',
        'activo'
    ];

    protected $casts = [
        'stock_actual' => 'decimal:2',
        'stock_minimo' => 'decimal:2',
        'costo_unitario' => 'decimal:2',
        'activo' => 'boolean'
    ];

    // Relaciones
    public function unidadMedida()
    {
        return $this->belongsTo(UnidadMedida::class);
    }

    public function detallesRecetas()
    {
        return $this->hasMany(DetalleReceta::class);
    }

    // Métodos helper
    public function tieneStockBajo()
    {
        return $this->stock_actual <= $this->stock_minimo;
    }

    public function descontarStock($cantidad)
    {
        $this->stock_actual -= $cantidad;
        $this->save();
    }

    public function aumentarStock($cantidad)
    {
        $this->stock_actual += $cantidad;
        $this->save();
    }

    /**
     * Relacion polimorfica con movimientos de inventario
     */
    public function movimientos(): MorphMany
    {
        return $this->morphMany(MovimientoInventario::class, 'inventariable');
    }
}
