<?php

use Tests\TestCase;
use App\Http\Controllers\Subject\SubjectController;
use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use App\Models\DTO\SubjectDTO;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubjectControllerUnitTest extends TestCase
{
    use DatabaseTransactions;

    private $subjectController;

    public function setUp(): void
    {
        parent::setUp();
        $this->subjectController = new \App\Http\Controllers\Subject\SubjectController();
    }

    public function testShouldCreateSubjectSuccessfully()
    {
        $requestMock = $this->createMock(SubjectRequest::class);
        $requestMock->expects($this->once())->method('validated')->willReturn(['name' => 'Fantasia']);

        $dtoMock = Mockery::mock(SubjectDTO::class);
        $dtoMock->shouldReceive('getAttribute')->andReturn('Fantasia');

        $this->app->instance(SubjectRequest::class, $requestMock);

        $response = $this->subjectController->store($requestMock);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testShouldNotCreateSubjectBecauseFormRequestValidation()
    {
        $requestPayload = [];

        $response = $this->post('/api/authors', $requestPayload);

        $response->assertStatus(302);
    }

    public function testShouldUpdateSubjectSuccessfully()
    {
        $subject = Subject::create([
            'Descricao' => 'Subject Test',
        ]);

        $requestMock = $this->createMock(SubjectRequest::class);
        $requestMock->expects($this->once())->method('validated')->willReturn(['name' => 'Melhoria Updated']);

        $dtoMock = Mockery::mock(SubjectDTO::class);
        $dtoMock->shouldReceive('getAttribute')->andReturn('Melhoria Updated');

        $this->app->instance(SubjectRequest::class, $requestMock);

        $response = $this->subjectController->update($requestMock, $subject->CodAs);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testShouldDeleteSubjectSuccessfully()
    {
        $subject = Subject::create([
            'Descricao' => 'Subject Test',
        ]);

        $response = $this->subjectController->destroy($subject->CodAs);

        $this->assertEquals(200, $response->getStatusCode());
    }

//    public function testShouldNotDeleteSubjectBecauseHasBooks()
//    {
//        $subject = Subject::create([
//            'Descricao' => 'Subject to be Deleted',
//        ]);
//
//        $response = $this->subjectController->destroy($subject->CodAs);
//
//        $this->assertEquals(200, $response->getStatusCode());
//    }

}



