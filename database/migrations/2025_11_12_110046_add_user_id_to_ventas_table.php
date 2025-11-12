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
    Schema::table('ventas', function (Blueprint $table) {
        // Añadimos la llave foránea
        // 'nullable' -> Para que las ventas antiguas no den error
        // 'constrained' -> Para conectarlo a la tabla 'users'
        // 'after' -> Para orden (opcional)
        $table->foreignId('user_id')->nullable()->constrained('users')->after('id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('ventas', function (Blueprint $table) {
        $table->dropForeign(['user_id']); // Elimina la llave foránea
        $table->dropColumn('user_id');   // Elimina la columna
    });
}
};
