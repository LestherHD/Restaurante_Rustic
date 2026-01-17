<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bebida extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'marca',
        'presentacion',
        'unidades_por_empaque',
        'stock_actual',
        'stock_minimo',
        'costo_unitario',
        'precio_venta',
        'imagen',
        'activo',
    ];

    protected $casts = [
        'unidades_por_empaque' => 'integer',
        'stock_actual' => 'decimal:2',
        'stock_minimo' => 'decimal:2',
        'costo_unitario' => 'decimal:2',
        'precio_venta' => 'decimal:2',
        'activo' => 'boolean',
    ];

    /**
     * Calcula cuántos empaques completos hay
     */
    public function getEmpaquesCompletosAttribute(): int
    {
        return (int) floor($this->stock_actual / $this->unidades_por_empaque);
    }

    /**
     * Calcula cuántas unidades sueltas sobran
     */
    public function getUnidadesSueltasAttribute(): int
    {
        return (int) ($this->stock_actual % $this->unidades_por_empaque);
    }

    /**
     * Verifica si el stock está bajo
     */
    public function tieneStockBajo(): bool
    {
        return $this->stock_actual <= $this->stock_minimo;
    }

    /**
     * Descuenta stock cuando se vende
     */
    public function descontarStock(float $cantidad): bool
    {
        if ($this->stock_actual >= $cantidad) {
            $this->stock_actual -= $cantidad;
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Aumenta stock cuando llega mercancía
     */
    public function aumentarStock(float $cantidad): void
    {
        $this->stock_actual += $cantidad;
        $this->save();
    }

    /**
     * Calcula el margen de ganancia en porcentaje
     */
    public function getMargenGananciaAttribute(): float
    {
        if ($this->costo_unitario == 0) {
            return 0;
        }
        return (($this->precio_venta - $this->costo_unitario) / $this->costo_unitario) * 100;
    }

    /**
     * Calcula la ganancia en dinero por unidad
     */
    public function getGananciaUnitariaAttribute(): float
    {
        return $this->precio_venta - $this->costo_unitario;
    }

    /**
     * Relacion polimorfica con movimientos de inventario
     */
    public function movimientos(): MorphMany
    {
        return $this->morphMany(MovimientoInventario::class, 'inventariable');
    }
}
