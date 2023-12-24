<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE VIEW report_books_by_author_grouping_by_books_view AS
            SELECT
                livros.\"Titulo\" AS Livro,
                livros.\"Editora\" AS Editora,
                livros.\"Edicao\" AS Edição,
                livros.\"AnoPublicacao\" AS Publicação,
                REPLACE(CAST(livros.\"Valor\" AS VARCHAR), '.', ',') AS Valor,
                STRING_AGG(DISTINCT autores.\"Nome\", ', ') AS Autores,
                STRING_AGG(DISTINCT assuntos.\"Descricao\", ', ' ORDER BY assuntos.\"Descricao\" ASC) AS Assuntos
            FROM
                autores
            JOIN
                livros_autores ON autores.\"CodAu\" = livros_autores.\"Autor_CodAu\"
            JOIN
                livros ON livros_autores.\"Livro_Codl\" = livros.\"Codl\"
            LEFT JOIN
                livros_assuntos ON livros.\"Codl\" = livros_assuntos.\"Livro_Codl\"
            LEFT JOIN
                assuntos ON livros_assuntos.\"Assunto_CodAs\" = assuntos.\"CodAs\"
            GROUP BY
                livros.\"Codl\", livros.\"Titulo\", livros.\"Editora\", livros.\"Edicao\", livros.\"AnoPublicacao\", livros.\"Valor\"
            ORDER BY
                livros.\"Titulo\", livros.\"AnoPublicacao\" ASC;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS report_books_by_author_grouping_by_books_view");
    }
};
