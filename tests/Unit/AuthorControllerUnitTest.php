<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\Author\AuthorController;
use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Models\DTO\AuthorDTO;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;

class AuthorControllerUnitTest extends TestCase
{
    use DatabaseTransactions;

    private $authorController;

    public function setUp(): void
    {
        parent::setUp();
        $this->authorController = new AuthorController();
    }

    public function testShouldCreateAuthorSuccessfully()
    {
        $requestMock = $this->createMock(AuthorRequest::class);
        $requestMock->expects($this->once())->method('validated')->willReturn(['name' => 'Marina Pelosi']);

        $dtoMock = Mockery::mock(AuthorDTO::class);
        $dtoMock->shouldReceive('getAttribute')->andReturn('Marina Pelosi');

        $this->app->instance(AuthorRequest::class, $requestMock);

        $response = $this->authorController->store($requestMock);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testShouldUpdateAuthorSuccessfully()
    {
        $author = Author::create([
            'Nome' => 'Author to be Updated',
        ]);

        $requestMock = $this->createMock(AuthorRequest::class);
        $requestMock->expects($this->once())->method('validated')->willReturn(['name' => 'Marina Updated']);

        $dtoMock = Mockery::mock(AuthorDTO::class);
        $dtoMock->shouldReceive('getAttribute')->andReturn('Marina Updated');

        $this->app->instance(AuthorRequest::class, $requestMock);

        $response = $this->authorController->update($requestMock, $author->CodAu);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testShouldDeleteAuthorSuccessfully()
    {
        $author = Author::create([
            'Nome' => 'Author to be Deleted',
        ]);

        $response = $this->authorController->destroy($author->CodAu);

        $this->assertEquals(200, $response->getStatusCode());
    }
}



