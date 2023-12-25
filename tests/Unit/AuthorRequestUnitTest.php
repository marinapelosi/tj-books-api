<?php

use App\Http\Requests\AuthorRequest;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AuthorRequestUnitTest extends TestCase
{

    private $authorRequest;

    public function setUp(): void
    {
        parent::setUp();
        $this->authorRequest = new AuthorRequest();
    }

    public function testShouldPassAuthorValidationSuccessfully()
    {
        $requestPayload = [
            'name' => 'Dado Correto',
        ];

        $validator = $this->app['validator']->make(
            $requestPayload,
            $this->authorRequest->rules(),
            $this->authorRequest->messages(),
            $this->authorRequest->attributes()
        );

        $this->assertFalse($validator->fails());
        $this->assertEmpty($validator->errors()->all());
    }

    public function testShouldNotPassAuthorValidation()
    {
        $requestPayload = [
            'name' => '',
        ];

        $this->expectException(ValidationException::class);

        $validator = $this->app['validator']->make(
            $requestPayload,
            $this->authorRequest->rules(),
            $this->authorRequest->messages(),
            $this->authorRequest->attributes()
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}




