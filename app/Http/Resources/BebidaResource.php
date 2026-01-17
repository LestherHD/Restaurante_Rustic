<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BebidaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'marca' => $this->marca,
            'presentacion' => $this->presentacion,
            'unidades_por_empaque' => $this->unidades_por_empaque,
            'stock_actual' => (float) $this->stock_actual,
            'stock_minimo' => (float) $this->stock_minimo,
            'costo_unitario' => (float) $this->costo_unitario,
            'precio_venta' => (float) $this->precio_venta,
            'imagen' => $this->imagen,
            'activo' => (bool) $this->activo,
            'empaques_completos' => $this->empaques_completos,
            'unidades_sueltas' => $this->unidades_sueltas,
            'stock_bajo' => $this->tieneStockBajo(),
            'margen_ganancia' => (float) $this->margen_ganancia,
            'ganancia_unitaria' => (float) $this->ganancia_unitaria,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
