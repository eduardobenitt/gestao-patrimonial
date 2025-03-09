<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('historico_alteracoes', function (Blueprint $table) {
            // 1) Remover a FK existente para poder alterar a coluna
            $table->dropForeign(['user_id']);

            // 2) Tornar user_id nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();

            // 3) Recriar a FK com onDelete('cascade') (padrão original)
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('historico_alteracoes', function (Blueprint $table) {
            // 1) Drop da FK novamente
            $table->dropForeign(['user_id']);

            // 2) Volta para NOT NULL
            $table->unsignedBigInteger('user_id')->nullable(false)->change();

            // 3) Recria a FK como era antes
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
};
