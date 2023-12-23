<?php

namespace App\Http\Controllers\Book;

use App\Enums\HttpResponseCodes;
use App\Http\Resources\BookResource;
use App\Libs\BookFilterLib;
use App\Models\Book;
use App\Http\Requests\BookRequest;
use App\Models\DTO\BookDTO;
use App\Services\BookAuthorService;
use App\Services\BookFieldService;
use App\Services\BookSubjectService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookAuthorService;
    protected $bookSubjectService;
    protected $bookFieldService;

    public function __construct(
        BookAuthorService $bookAuthorService,
        BookSubjectService $bookSubjectService,
        BookFieldService $bookFieldService
    ) {
        $this->bookAuthorService = $bookAuthorService;
        $this->bookSubjectService = $bookSubjectService;
        $this->bookFieldService = $bookFieldService;
    }

    public function index(): JsonResponse
    {
        return response()->success(
            __('book.list'),
            BookResource::collection((new BookFilterLib())->withRelations()->orderBy()->get())
        );
    }

    public function filter(Request $request)
    {
        $filters = $request->all();

        return BookResource::collection(
            (new BookFilterLib(collect($filters)))->filter()->withRelations()->orderBy()->get()
        );
    }

    public function show(string $id): JsonResponse
    {
        $book = Book::where('Codl', $id)->first();

        if (!$book) {
            return response()->error(__('book.notFound'), HttpResponseCodes::HttpNotFound);
        }

        return response()->success(
            __('book.getOne'),
            BookResource::make($book)
        );
    }

    public function store(BookRequest $request): JsonResponse
    {
        $dto = new BookDTO($request->validated());

        $book = Book::create($this->bookFieldService->mapFields(($dto)));
        $this->bookAuthorService->attachAuthors($book, $dto->authors);
        $this->bookSubjectService->attachSubjects($book, $dto->subjects);

        return response()->success(
            __('book.created'),
            BookResource::make($book->refresh()),
            HttpResponseCodes::HttpCreated
        );
    }

    public function update(BookRequest $request, $id): JsonResponse
    {
        $dto = new BookDTO($request->validated());

        $book = Book::findOrFail($id);
        $book->update($this->bookFieldService->mapFields(($dto)));
        $this->bookAuthorService->syncAuthors($book, $dto->authors);
        $this->bookSubjectService->syncSubjects($book, $dto->subjects);

        return response()->success(
            __('book.updated'),
            BookResource::make($book->refresh()),
        );
    }

    public function destroy($id): JsonResponse
    {
        $book = Book::findOrFail($id);
        $this->bookAuthorService->detachAuthors($book);
        $this->bookSubjectService->detachSubjects($book);
        $book->delete();

        return response()->success(
            __('book.deleted'),
            []
        );
    }
}
