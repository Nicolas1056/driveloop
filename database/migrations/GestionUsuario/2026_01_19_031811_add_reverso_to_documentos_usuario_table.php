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
            // 1. Agregar la columna para el reverso
            // La agregamos después de 'url_anverso'
            $table->string('url_reverso', 255)->nullable()->after('url_anverso');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos_usuario', function (Blueprint $table) {
            $table->dropColumn('url_reverso');
        });
    }
};