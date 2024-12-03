<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('infomovimientos', function (Blueprint $table) {
            $table->id();
            $table->text('mensaje')->nullable();
            $table->string('vicepresidencia');
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('idMovimientoProducto');
            $table->foreign('idMovimientoProducto')->references('id')->on('movimientos_productos');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('infomovimientos');
    }
};
