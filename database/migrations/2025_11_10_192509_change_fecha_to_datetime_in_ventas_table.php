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
    Schema::table('ventas', function (Blueprint $table) {
        // Cambiamos el tipo de 'date' a 'dateTime'
        $table->dateTime('fecha')->default(now())->change();
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('ventas', function (Blueprint $table) {
        // Lo revertimos a 'date' si es necesario
        $table->date('fecha')->default(now())->change();
    });
}
};
