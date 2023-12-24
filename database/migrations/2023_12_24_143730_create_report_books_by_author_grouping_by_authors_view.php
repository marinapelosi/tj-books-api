<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE VIEW report_books_by_author_grouping_by_authors_view AS
            SELECT
                STRING_AGG(DISTINCT autores.\"Nome\", ', ') AS authors,
                livros.\"Titulo\" AS book,
                livros.\"Editora\" AS publisher,
                livros.\"Edicao\" AS edition,
                livros.\"AnoPublicacao\" AS publicationYear,
                REPLACE(CAST(livros.\"Valor\" AS VARCHAR), '.', ',') AS price,
                STRING_AGG(DISTINCT assuntos.\"Descricao\", ', ' ORDER BY assuntos.\"Descricao\" ASC) AS subjects
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
                authors ASC, livros.\"Titulo\", livros.\"AnoPublicacao\" ASC;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS report_books_by_author_grouping_by_authors_view");
    }
};
