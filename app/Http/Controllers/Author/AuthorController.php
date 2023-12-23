<?php

namespace App\Http\Controllers\Author;

use App\Enums\HttpResponseCodes;
use App\Exceptions\AuthorWithBooksException;
use App\Http\Resources\AuthorResource;
use App\Libs\AuthorFilterLib;
use App\Models\Author;
use App\Http\Requests\AuthorRequest;
use App\Models\BookAuthor;
use App\Models\DTO\AuthorDTO;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->success(
            __('author.list'),
            AuthorResource::collection((new AuthorFilterLib())->orderBy()->get())
        );
    }

    public function filter(Request $request)
    {
        $filters = $request->all();

        return AuthorResource::collection(
            (new AuthorFilterLib(collect($filters)))->filter()->orderBy()->get()
        );
    }

    public function show(string $id): JsonResponse
    {
        $author = Author::where('CodAu', $id)->first();

        if (!$author) {
            return response()->error(__('author.notFound'), HttpResponseCodes::HttpNotFound);
        }

        return response()->success(
            __('author.getOne'),
            AuthorResource::make($author)
        );
    }

    public function store(AuthorRequest $request): JsonResponse
    {
        $dto = new AuthorDTO($request->validated());

        $author = Author::create([
            'Nome' => $dto->name,
        ]);

        return response()->success(
            __('author.created'),
            AuthorResource::make($author),
            HttpResponseCodes::HttpCreated
        );
    }

    /**
     * @method PUT
     */
    public function update(AuthorRequest $request, $id): JsonResponse
    {
        $dto = new AuthorDTO($request->validated());

        $author = Author::findOrFail($id);
        $author->update([
            'Nome' => $dto->name,
        ]);

        return response()->success(
            __('author.updated'),
            AuthorResource::make($author)
        );
    }

    public function destroy($id): JsonResponse
    {
        $author = Author::findOrFail($id);

        try {
            if (BookAuthor::where('Autor_CodAu', $author->id)->first()) {
                throw new AuthorWithBooksException();
            }

            $author->delete();

            return response()->success(
                __('author.deleted'),
                []
            );
        } catch (AuthorWithBooksException $exception) {
            return response()->error(__('author.error_delete_with_books'));
        }
    }
}
