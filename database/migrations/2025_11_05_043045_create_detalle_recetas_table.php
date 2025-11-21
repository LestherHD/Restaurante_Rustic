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
        Schema::create('detalle_recetas', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo',['ingrediente','subreceta']);
            $table->decimal('cantidad',8,2);
            $table->foreignId('receta_id')->constrained()->onDelete('cascade');
            $table->foreignId('ingrediente_id')->constrained()->onDelete('cascade');
            $table->foreignId('subreceta_id')->constrained('recetas')->onDelete('cascade');
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_recetas');
    }
};
