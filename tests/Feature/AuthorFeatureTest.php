<?php

use App\Exceptions\SubjectWithBooksException;
use Tests\TestCase;
use App\Models\Author;
use App\Models\Subject;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\BookSubject;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthorFeatureTest extends TestCase
{
    use DatabaseTransactions;

    private $route;

    public function setUp(): void
    {
        parent::setUp();
        $this->route = '/api/authors';
    }

    public function testShouldCreateAuthorSuccessfully()
    {
        $requestPayload = [
            'name' => 'New Author'
        ];

        $response = $this->post($this->route, $requestPayload);

        $response->assertStatus(201);
    }

    public function testShouldNotCreateAuthorBecauseFormRequestValidation()
    {
        $requestPayload = [];

        $response = $this->post($this->route, $requestPayload);

        $response->assertStatus(302);
    }

    public function testShouldUpdateAuthorSuccessfully()
    {
         $author = Author::create([
            'Nome' => 'Author',
        ]);

        $requestPayload = [
            'name' => 'Author Updated'
        ];

        $response = $this->put($this->route.'/'.$author->CodAu, $requestPayload);

        $response->assertStatus(200);
    }

    public function testShouldDeleteAuthorSuccessfully()
    {
        $author = Author::create([
            'Nome' => 'Author',
        ]);

        $response = $this->delete($this->route.'/'.$author->CodAu);

        $response->assertStatus(200);
    }

    public function testShouldNotDeleteAuthorBecauseItHasBooks()
    {
        $author = Author::create([
            'Nome' => 'Author',
        ]);

        $subject = Subject::create([
            'Descricao' => 'Subject',
        ]);

//        $book = Book::create([
//            'title' => 'Teste de edição',
//            'publisher' => 'Sextante',
//            'edition' => '1',
//            'publicationYear' => '2023',
//            'price' => '20,00',
//            'authors' => [$author->CodAu],
//            'subjects' => [$subject->CodAs]
//        ]);

        $book = Book::create([
            'Titulo' => 'Teste de edição',
            'Editora' => 'Sextante',
            'Edicao' => '1',
            'AnoPublicacao' => '2023',
            'Valor' => '20.00'
        ]);

        $bookAuthor = BookAuthor::create([
            'Livro_Codl' => $book->Codl,
            'Autor_CodAu' => $author->CodAu
        ]);

        $bookSubject = BookSubject::create([
            'Livro_Codl' => $book->Codl,
            'Assunto_CodAs' => $subject->CodAs
        ]);

        $response = $this->delete($this->route.'/'.$author->CodAu);

        $response->assertStatus(404);
    }
}



