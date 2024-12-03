<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->decimal('cantidad', 10, 2);
            $table->unsignedBigInteger('idCategoria')->nullable();
            $table->unsignedBigInteger('unidad_medida_id');
            $table->decimal('cantidad_minima', 8, 2);
            $table->date('fecharegistro');
            $table->decimal('cantidad_unidad_compuesta', 10, 4)->nullable();
            $table->decimal('cantidad_total', 15,4)->nullable();
            $table->timestamps();

       
            $table->index('idCategoria');
            $table->index('unidad_medida_id');

           
            $table->foreign('idCategoria')->references('id')->on('categorias');
            $table->foreign('unidad_medida_id')->references('id')->on('unidades_medida');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
