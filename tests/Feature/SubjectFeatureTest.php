<?php

use App\Exceptions\SubjectWithBooksException;
use Tests\TestCase;
use App\Models\Author;
use App\Models\Subject;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\BookSubject;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubjectFeatureTest extends TestCase
{
    use DatabaseTransactions;

    private $route;

    public function setUp(): void
    {
        parent::setUp();
        $this->route = '/api/subjects';
    }

    public function testShouldCreateSubjectSuccessfully()
    {
        $requestPayload = [
            'description' => 'New Subject'
        ];

        $response = $this->post($this->route, $requestPayload);

        $response->assertStatus(201);
    }

    public function testShouldNotCreateSubjectBecauseFormRequestValidation()
    {
        $requestPayload = [];

        $response = $this->post($this->route, $requestPayload);

        $response->assertStatus(302);
    }

    public function testShouldUpdateSubjectSuccessfully()
    {
         $subject = Subject::create([
            'Descricao' => 'Subject',
        ]);

        $requestPayload = [
            'description' => 'Subject Updated'
        ];

        $response = $this->put($this->route.'/'.$subject->CodAs, $requestPayload);

        $response->assertStatus(200);
    }

    public function testShouldDeleteSubjectSuccessfully()
    {
        $subject = Subject::create([
            'Descricao' => 'Subject',
        ]);

        $response = $this->delete($this->route.'/'.$subject->CodAs);

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

        $response = $this->delete($this->route.'/'.$subject->CodAs);

        $response->assertStatus(404);
    }
}



