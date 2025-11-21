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
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_movimiento',['entrada','salida']);
            $table->decimal('cantidad',8,2);
            $table->string('referencia_tipo',50)->nullable();
            $table->text('comentario')->nullable();
            $table->date('fecha_movimiento')->nullable();
            $table->foreignId('ingrediente_id')->constrained('ingredientes')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};
