<?php

use App\Http\Requests\BookRequest;
use Illuminate\Validation\ValidationException;
use App\Models\Author;
use App\Models\Subject;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\BookSubject;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookRequestUnitTest extends TestCase
{

    use DatabaseTransactions;
    private $bookRequest;

    public function setUp(): void
    {
        parent::setUp();
        $this->bookRequest = new BookRequest();
    }

    public function testShouldPassAuthorValidationSuccessfully()
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

        $validator = $this->app['validator']->make(
            $requestPayload,
            $this->bookRequest->rules(),
            $this->bookRequest->messages(),
            $this->bookRequest->attributes()
        );

        $this->assertFalse($validator->fails());
        $this->assertEmpty($validator->errors()->all());
    }

    public function testShouldNotPassAuthorValidation()
    {
        $requestPayloadWrongData = [
            'title' => '',
            'publisher' => 'Sextante',
            'edition' => '1',
            'publicationYear' => '2023aaa',
            'price' => 'absd20,00',
            'authors' => [],
            'subjects' => []
        ];

        $this->expectException(ValidationException::class);

        $validator = $this->app['validator']->make(
            $requestPayloadWrongData,
            $this->bookRequest->rules(),
            $this->bookRequest->messages(),
            $this->bookRequest->attributes()
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}




