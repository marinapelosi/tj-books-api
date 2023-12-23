<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('livros_autores', function (Blueprint $table) {
            $table->ulid('Id')->primary();
            $table->ulid('Livro_Codl')->index();
            $table->ulid('Autor_CodAu')->index();
            $table->timestamps();

            $table->foreign('Livro_Codl')->references('Codl')->on('livros');
            $table->foreign('Autor_CodAu')->references('CodAu')->on('autores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livros_autores');
    }
};
