<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('maquina_user', function (Blueprint $table) {
            $table->enum('turno', ['manha', 'tarde'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maquina_user', function (Blueprint $table) {
            //
        });
    }
};
