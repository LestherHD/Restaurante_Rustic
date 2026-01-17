<?php

namespace App\Filament\Resources\MovimientoInventarios\Pages;

use App\Filament\Resources\MovimientoInventarios\MovimientoInventarioResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateMovimientoInventario extends CreateRecord
{
    protected static string $resource = MovimientoInventarioResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Asignar el usuario actual
        $data['user_id'] = auth()->id();
        
        // Si es una bebida y tiene cantidad_cajas, calcular cantidad total
        if (isset($data['inventariable_type']) && $data['inventariable_type'] === 'App\\Models\\Bebida') {
            if (isset($data['cantidad_cajas']) && $data['inventariable_id']) {
                $bebida = \App\Models\Bebida::find($data['inventariable_id']);
                if ($bebida) {
                    $data['cantidad'] = $data['cantidad_cajas'] * $bebida->unidades_por_empaque;
                }
            }
        }
        
        return $data;
    }

    protected function afterCreate(): void
    {
        // Aplicar el movimiento al inventario automaticamente
        $this->record->aplicarMovimiento();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
