<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // Crea la columna 'id' (autoincremental, llave primaria)
            
            $table->string('nombre');
            $table->text('descripcion')->nullable(); // .nullable() significa que es opcional
            $table->decimal('precio', 10);    // 10 dígitos en total, 2 para decimales
            $table->integer('stock');
            
            $table->timestamps(); // Crea 'created_at' y 'updated_at' automáticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
