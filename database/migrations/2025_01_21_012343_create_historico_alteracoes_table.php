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
            $table->string('tipo');
            $table->text('descricao');
            $table->timestamp('data')->default(now());
            $table->foreignId('usuario_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->unsignedBigInteger('referencia_id')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historico_alteracoes');
    }
};
