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
        Schema::create('livros_assuntos', function (Blueprint $table) {
            $table->ulid('Id')->primary();
            $table->ulid('Livro_Codl')->index();
            $table->ulid('Assunto_CodAs')->index();
            $table->timestamps();

            $table->foreign('Livro_Codl')->references('Codl')->on('livros');
            $table->foreign('Assunto_CodAs')->references('CodAs')->on('assuntos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livros_assuntos');
    }
};
