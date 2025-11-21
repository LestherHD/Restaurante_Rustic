<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('costos_platos', function (Blueprint $table) {
            $table->id();
            $table->decimal('costo_total', 10, 2);
            $table->decimal('costo_utilidad', 10, 2);
            $table->decimal('sugerencia_precio_venta', 10, 2)->nullable();
            $table->foreignId('plato_id')->constrained('platos')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costos_platos');
    }
};
