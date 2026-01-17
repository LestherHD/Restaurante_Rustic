<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bebidas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('marca')->nullable();
            $table->string('presentacion'); // "Lata 355ml", "Botella 600ml"
            $table->integer('unidades_por_empaque')->default(1); // Cuántas trae cada caja/paquete
            $table->decimal('stock_actual', 10, 2)->default(0); // En unidades individuales
            $table->decimal('stock_minimo', 10, 2)->default(0);
            $table->decimal('costo_unitario', 10, 2); // Costo por unidad individual
            $table->decimal('precio_venta', 10, 2); // Precio de venta al público
            $table->string('imagen')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bebidas');
    }
};
