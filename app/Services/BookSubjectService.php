<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BookSubject;

class BookSubjectService
{
    public function attachSubjects(Book $book, array $subjectIds): void
    {
        foreach ($subjectIds as $subjectId) {
            BookSubject::create([
                'Livro_Codl' => $book->Codl,
                'Assunto_CodAs' => $subjectId
            ]);
        }
    }

    public function detachSubjects(Book $book, array $subjectsId = null): void
    {
        if (!is_null($subjectsId)) {
            $bookSubjects = BookSubject::where('Livro_Codl', $book->Codl)->whereIn($subjectsId)->get();
            $bookSubjects->forceDelete();
        }

        $bookSubjects = BookSubject::where('Livro_Codl', $book->Codl);
        $bookSubjects->forceDelete();
    }

    public function syncSubjects(Book $book, array $subjectsId): void
    {
        $this->detachSubjects($book);
        $this->attachSubjects($book, $subjectsId);
    }
}
