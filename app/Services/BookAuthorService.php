<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BookAuthor;

class BookAuthorService
{
    public function attachAuthors(Book $book, array $authorIds): void
    {
        foreach ($authorIds as $authorId) {
            BookAuthor::create([
                'Livro_Codl' => $book->Codl,
                'Autor_CodAu' => $authorId
            ]);
        }
    }

    public function detachAuthors(Book $book, array $authorIds = null): void
    {
        if (!is_null($authorIds)) {
            $bookAuthors = BookAuthor::where('Livro_Codl', $book->Codl)->whereIn($authorIds)->get();
            $bookAuthors->forceDelete();
        }

        $bookAuthors = BookAuthor::where('Livro_Codl', $book->Codl);
        $bookAuthors->forceDelete();
    }

    public function syncAuthors(Book $book, array $authorIds): void
    {
        $this->detachAuthors($book);
        $this->attachAuthors($book, $authorIds);
    }
}
