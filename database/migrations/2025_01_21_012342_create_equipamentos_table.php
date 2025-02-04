<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id();
            $table->string('patrimonio')->unique();
            $table->string('fabricante')->nullable(); 
            $table->text('especificacoes')->nullable(); 
            $table->foreignId('maquina_id')->nullable() 
                  ->constrained('maquinas')
                  ->onDelete('set null');
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipamentos');
    }
};
