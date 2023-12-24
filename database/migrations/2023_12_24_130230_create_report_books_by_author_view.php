<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $query = "
        CREATE VIEW report_books_by_author_view AS
        SELECT
            autores.\"Nome\" AS Autor,
            livros.\"Titulo\" AS Livro,
            livros.\"Editora\" AS Editora,
            livros.\"Edicao\" AS Edição,
            livros.\"AnoPublicacao\" AS Publicação,
            REPLACE(CAST(livros.\"Valor\" AS VARCHAR), '.', ',') AS Valor,
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
            autores.\"CodAu\", autores.\"Nome\", livros.\"Codl\", livros.\"Titulo\", livros.\"AnoPublicacao\"
        ORDER BY
            autores.\"Nome\" ASC, livros.\"Titulo\", livros.\"AnoPublicacao\" ASC;
        ";

        DB::statement($query);
    }

    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS report_books_by_author_view');
    }
};
