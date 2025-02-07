<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historico_alteracoes', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('maquina_id')->nullable()->constrained('maquinas')->onDelete('set null');
            $table->foreignId('equipamento_id')->nullable()->constrained('equipamentos')->onDelete('set null');
            $table->timestamp('alterado_em')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historico_alteracoes');
    }
};
