<?php

namespace App\Http\Controllers\Subject;

use App\Enums\HttpResponseCodes;
use App\Exceptions\SubjectWithBooksException;
use App\Http\Resources\SubjectResource;
use App\Libs\SubjectFilterLib;
use App\Models\BookSubject;
use App\Models\DTO\SubjectDTO;
use App\Models\Subject;
use App\Http\Requests\SubjectRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->success(
            __('subject.list'),
            SubjectResource::collection((new SubjectFilterLib())->orderBy()->get())
        );
    }

    public function filter(Request $request)
    {
        $filters = $request->all();

        return SubjectResource::collection(
            (new SubjectFilterLib(collect($filters)))->filter()->orderBy()->get()
        );
    }

    public function show($id): JsonResponse
    {
        $subject = Subject::where('CodAs', $id)->first();

        if (!$subject) {
            return response()->error(__('subject.notFound'), HttpResponseCodes::HttpNotFound);
        }

        return response()->success(
            __('subject.getOne'),
            SubjectResource::make($subject)
        );
    }

    public function store(SubjectRequest $request): JsonResponse
    {
        $dto = new SubjectDTO($request->validated());

        $subject = Subject::create([
            'Descricao' => $dto->description,
        ]);

        return response()->success(
            __('subject.created'),
            SubjectResource::make($subject),
            HttpResponseCodes::HttpCreated
        );
    }

    public function update(SubjectRequest $request, $id): JsonResponse
    {
        $dto = new SubjectDTO($request->validated());

        $subject = Subject::findOrFail($id);
        $subject->update([
            'Descricao' => $dto->description,
        ]);

        return response()->success(
            __('subject.updated'),
            SubjectResource::make($subject)
        );
    }

    public function destroy($id): JsonResponse
    {
        $subject = Subject::findOrFail($id);

        try {
            if (BookSubject::where('Assunto_CodAs', $subject->CodAs)->first()) {
                throw new SubjectWithBooksException();
            }

            $subject->delete();

            return response()->success(
                __('subject.deleted'),
                []
            );
        } catch (SubjectWithBooksException $exception) {
            return response()->error(__('subject.error_delete_with_books'));
        }
    }
}
