<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('unidades_compuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unidad_compuesta_id');
            $table->unsignedBigInteger('unidad_simple_id');
            $table->decimal('cantidad', 10, 4);
            $table->timestamps();
        
            $table->foreign('unidad_compuesta_id')->references('id')->on('unidades_medida');
            $table->foreign('unidad_simple_id')->references('id')->on('unidades_medida');

        });
    }
  
    public function down(): void
    {
        Schema::dropIfExists('unidades_compuestas');
    }
};
