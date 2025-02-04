<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maquinas', function (Blueprint $table) {
            $table->id();
            $table->string('patrimonio')->unique(); 
            $table->string('fabricante')->nullable(); 
            $table->text('especificacoes')->nullable(); 
            $table->enum('status', ['em uso', 'no almoxarifado'])->default('no almoxarifado');
            $table->foreignId('user_id')->nullable() 
                  ->constrained('users')
                  ->onDelete('set null');
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maquinas');
    }
};
