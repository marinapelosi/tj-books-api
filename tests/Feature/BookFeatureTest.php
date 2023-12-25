<?php

use Tests\TestCase;
use App\Models\Author;
use App\Models\Subject;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\BookSubject;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookFeatureTest extends TestCase
{
    use DatabaseTransactions;

    private $route;

    public function setUp(): void
    {
        parent::setUp();
        $this->route = '/api/books';
    }

    public function testShouldCreateBookSuccessfully()
    {
        $author = Author::create([
            'Nome' => 'Author',
        ]);

        $subject = Subject::create([
            'Descricao' => 'Subject',
        ]);

        $requestPayload = [
            'title' => 'Título',
            'publisher' => 'Sextante',
            'edition' => '1',
            'publicationYear' => '2023',
            'price' => '20,00',
            'authors' => [$author->CodAu],
            'subjects' => [$subject->CodAs]
        ];

        $response = $this->post($this->route, $requestPayload);

        $response->assertStatus(201);
    }

    public function testShouldNotCreateBookBecauseFormRequestValidation()
    {
        $requestPayload = [];

        $response = $this->post($this->route, $requestPayload);

        $response->assertStatus(302);
    }

    public function testShouldUpdateBookSuccessfully()
    {
        $author = Author::create([
            'Nome' => 'Author',
        ]);

        $subject = Subject::create([
            'Descricao' => 'Subject',
        ]);

        $book = Book::create([
            'Titulo' => 'Título',
            'Editora' => 'Sextante',
            'Edicao' => '1',
            'AnoPublicacao' => '2023',
            'Valor' => '20.00'
        ]);

        BookAuthor::create([
            'Livro_Codl' => $book->Codl,
            'Autor_CodAu' => $author->CodAu
        ]);

        BookSubject::create([
            'Livro_Codl' => $book->Codl,
            'Assunto_CodAs' => $subject->CodAs
        ]);

        $requestPayload = [
            'title' => 'Teste de edição',
            'publisher' => 'Sextante',
            'edition' => '1',
            'publicationYear' => '2023',
            'price' => '20,00',
            'authors' => [$author->CodAu],
            'subjects' => [$subject->CodAs]
        ];

        $response = $this->put($this->route.'/'.$book->Codl, $requestPayload);

        $response->assertStatus(200);
    }

    public function testShouldDeleteBookSuccessfully()
    {
        $author = Author::create([
            'Nome' => 'Author',
        ]);

        $subject = Subject::create([
            'Descricao' => 'Subject',
        ]);

        $book = Book::create([
            'Titulo' => 'Título',
            'Editora' => 'Sextante',
            'Edicao' => '1',
            'AnoPublicacao' => '2023',
            'Valor' => '20.00'
        ]);

        BookAuthor::create([
            'Livro_Codl' => $book->Codl,
            'Autor_CodAu' => $author->CodAu
        ]);

        BookSubject::create([
            'Livro_Codl' => $book->Codl,
            'Assunto_CodAs' => $subject->CodAs
        ]);

        $response = $this->delete($this->route.'/'.$book->Codl);

        $response->assertStatus(200);
    }
}



