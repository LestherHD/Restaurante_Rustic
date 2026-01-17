<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimientoInventario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'movimientos_inventario';

    protected $fillable = [
        'inventariable_id',
        'inventariable_type',
        'tipo_movimiento',
        'cantidad',
        'motivo',
        'comentario',
        'fecha_movimiento',
        'user_id',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'fecha_movimiento' => 'date',
    ];

    /**
     * Relacion polimorfica: puede ser Bebida o Ingrediente
     */
    public function inventariable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Usuario que registro el movimiento
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para filtrar por tipo de movimiento
     */
    public function scopeTipoEntrada($query)
    {
        return $query->where('tipo_movimiento', 'entrada');
    }

    public function scopeTipoSalida($query)
    {
        return $query->where('tipo_movimiento', 'salida');
    }

    public function scopeTipoAjuste($query)
    {
        return $query->where('tipo_movimiento', 'ajuste');
    }

    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeEntreFechas($query, $inicio, $fin)
    {
        return $query->whereBetween('fecha_movimiento', [$inicio, $fin]);
    }

    /**
     * Aplica el movimiento al inventario
     */
    public function aplicarMovimiento(): void
    {
        $inventariable = $this->inventariable;

        if ($this->tipo_movimiento === 'entrada') {
            $inventariable->aumentarStock($this->cantidad);
        } elseif ($this->tipo_movimiento === 'salida') {
            $inventariable->descontarStock($this->cantidad);
        } elseif ($this->tipo_movimiento === 'ajuste') {
            // Para ajustes, la cantidad puede ser positiva o negativa
            if ($this->cantidad > 0) {
                $inventariable->aumentarStock(abs($this->cantidad));
            } else {
                $inventariable->descontarStock(abs($this->cantidad));
            }
        }
    }
}
