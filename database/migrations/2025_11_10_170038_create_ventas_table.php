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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id(); // 'id' autoincremental
            
            // Esta será la llave foránea que conecta con la tabla 'productos'
            $table->foreignId('producto_id')->constrained('productos');
            
            $table->integer('cantidad');
            $table->decimal('total', 10);
            $table->date('fecha')->default(now()); // 'now()' toma la fecha actual
            
            // Columna tipo ENUM
            $table->enum('tipo_pago', ['efectivo', 'debito', 'credito'])->default('efectivo');

            // 'timestamps()' no es necesario aquí, ya que tienes 'fecha'
            // $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
