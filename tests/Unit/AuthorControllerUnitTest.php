<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use App\Http\Controllers\Author\AuthorController;
use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Models\DTO\AuthorDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\Uid\Ulid;
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

    public function testStoreAuthor()
    {
        $requestMock = $this->createMock(AuthorRequest::class);
        $requestMock->expects($this->once())->method('validated')->willReturn(['name' => 'Marina Pelosi']);

        $dtoMock = Mockery::mock(AuthorDTO::class);
        $dtoMock->shouldReceive('getAttribute')->andReturn('Marina Pelosi');

        $this->app->instance(AuthorRequest::class, $requestMock);

        $response = $this->authorController->store($requestMock);

        $this->assertEquals(201, $response->getStatusCode());
    }

//    public function testUpdateAuthor()
//    {
//        // Criar um autor no banco de dados para ser atualizado
//        $author = Author::create([
//            'Nome' => 'Author to be Updated',
//        ]);
//
//        // Mock dos dados a serem enviados no corpo da requisição
//        $requestData = [
//            'name' => 'Updated Name',
//        ];
//
//        // Faz a requisição para o endpoint de atualização
////        $response = $this->call('PUT', "api/authors/{$author->id}", $requestData);
//        $response = $this->withHeaders(['X-CSRF-TOKEN' => csrf_token()])
//            ->json('PUT', "api/authors/{$author->id}", $requestData, ['Accept' => 'application/json']);
//
//        // Verifica se a resposta está correta
//        $response->assertStatus(200);
//
//        // Verifica se o nome do autor foi atualizado no banco de dados
//        $this->assertDatabaseHas('authors', [
//            'CodAu' => $author->id,
//            'Nome' => 'Updated Name',
//        ]);
//    }

}



