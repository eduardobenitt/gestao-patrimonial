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
        Schema::table('equipamentos', function (Blueprint $table) {
            //
            $table->foreignId('produto_id')->nullable()->constrained('produtos')->onDelete('cascade');
            $table->enum('status', ['Almoxarifado', 'Em Uso'])->default('Almoxarifado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipamentos', function (Blueprint $table) {
            $table->dropForeign(['produto_id']);
            $table->dropColumn('produto_id');

            $table->dropColumn('status');
        });
    }
};
