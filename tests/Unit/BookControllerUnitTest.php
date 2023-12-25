<?php


use Tests\TestCase;
use App\Http\Controllers\Book\BookController;
use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Subject;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\BookSubject;
use App\Models\DTO\BookDTO;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Services\BookAuthorService;
use App\Services\BookSubjectService;
use App\Services\BookFieldService;

class BookControllerUnitTest extends TestCase
{
    use DatabaseTransactions;

    private $bookController;
    private $bookAuthorService;
    private $bookSubjectService;
    private $bookFieldService;

    public function setUp(): void
    {
        parent::setUp();
        $this->bookAuthorService = new BookAuthorService();
        $this->bookSubjectService = new BookSubjectService();
        $this->bookFieldService = new BookFieldService();

        $this->bookController = new BookController(
            $this->bookAuthorService,
            $this->bookSubjectService,
            $this->bookFieldService
        );
    }

    public function testShouldCreateBookSuccessfully()
    {
        $requestMock = $this->createMock(BookRequest::class);
        $requestMock->expects($this->once())->method('validated')->willReturn(
            [
                'title' => 'Título',
                'publisher' => 'Sextante',
                'edition' => '1',
                'publicationYear' => '2023',
                'price' => '20,00'
            ]
        );

        $dtoMock = Mockery::mock(BookDTO::class);
        $dtoMock->shouldReceive('getAttribute')->andReturn('Marina Pelosi');

        $this->app->instance(BookRequest::class, $requestMock);

        $response = $this->bookController->store($requestMock);

        $this->assertEquals(201, $response->getStatusCode());
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
            'Titulo' => 'Teste de edição',
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

        $requestMock = $this->createMock(BookRequest::class);
        $requestMock->expects($this->once())->method('validated')->willReturn(
            [
                'title' => 'Título Editado',
                'publisher' => 'Sextante',
                'edition' => '1',
                'publicationYear' => '2023',
                'price' => '20,00'
            ]
        );

        $dtoMock = Mockery::mock(BookDTO::class);
        $dtoMock->shouldReceive('getAttribute')->andReturn(
            [
                'title' => 'Título Editado',
                'publisher' => 'Sextante',
                'edition' => '1',
                'publicationYear' => '2023',
                'price' => '20,00'
            ]
        );

        $this->app->instance(BookRequest::class, $requestMock);

        $response = $this->bookController->update($requestMock, $book->Codl);

        $this->assertEquals(200, $response->getStatusCode());
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
            'Titulo' => 'Teste de edição',
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

        $response = $this->bookController->destroy($book->Codl);

        $this->assertEquals(200, $response->getStatusCode());
    }
}



