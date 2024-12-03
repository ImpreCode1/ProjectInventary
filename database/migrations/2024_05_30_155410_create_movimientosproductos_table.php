<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('movimientos_productos', function (Blueprint $table) {
            $table->id();
            // $table->integer('cantidadUsada');
            $table->decimal('cantidadUsada', 10 , 2);
            $table->unsignedBigInteger('idProducto')->nullable();
            $table->foreign('idProducto')->references('id')->on('productos');
            $table->unsignedBigInteger('idUsuario')->nullable();
            $table->foreign('idUsuario')->references('id')->on('usuarios');
            $table->datetime('fecha');
            $table->timestamps();

        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('movimientos_productos');
    }
};
