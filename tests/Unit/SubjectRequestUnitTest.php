<?php

use App\Http\Requests\SubjectRequest;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class SubjectRequestUnitTest extends TestCase
{

    private $subjectRequest;

    public function setUp(): void
    {
        parent::setUp();
        $this->subjectRequest = new SubjectRequest();
    }

    public function testShouldPassSubjectValidationSuccessfully()
    {
        $requestPayload = [
            'description' => 'Dado Correto',
        ];

        $validator = $this->app['validator']->make(
            $requestPayload,
            $this->subjectRequest->rules(),
            $this->subjectRequest->messages(),
            $this->subjectRequest->attributes()
        );

        $this->assertFalse($validator->fails());
        $this->assertEmpty($validator->errors()->all());
    }

    public function testShouldNotPassSubjectValidation()
    {
        $requestPayload = [
            'description' => '',
        ];

        $this->expectException(ValidationException::class);

        $validator = $this->app['validator']->make(
            $requestPayload,
            $this->subjectRequest->rules(),
            $this->subjectRequest->messages(),
            $this->subjectRequest->attributes()
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}




