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
        Schema::table('maquina_user', function (Blueprint $table) {
            // Remove a coluna "turno"
            $table->dropColumn('turno');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maquina_user', function (Blueprint $table) {
            // Recria a coluna "turno".
            // Definindo os valores possíveis do enum. Ajuste os valores conforme a necessidade do seu projeto.
            $table->enum('turno', ['Manhã', 'Tarde'])->nullable();
        });
    }
};
