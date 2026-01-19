<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('documentos_usuario', function (Blueprint $table) {
            // Ruta relativa donde se almacenará el archivo (ej: documentos/10/cedula.jpg)
            // Se usa string 255 es suficiente para rutas relativas.
            $table->string('url_archivo', 255)->nullable()->after('num');

            // Estado de la verificación. Por defecto es PENDIENTE al subirlo.
            $table->enum('estado', ['PENDIENTE', 'APROBADO', 'RECHAZADO'])
                ->default('PENDIENTE')
                ->after('url_archivo');

            // Mensaje opcional para explicar por qué se rechazó (si aplica)
            $table->text('mensaje_rechazo')->nullable()->after('estado');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos_usuario', function (Blueprint $table) {
            $table->dropColumn(['url_archivo', 'estado', 'mensaje_rechazo']);
        });
    }
};
