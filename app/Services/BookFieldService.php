<?php

namespace App\Services;

use App\Models\DTO\BookDTO;

class BookFieldService
{
    public function mapFields(BookDTO $dto)
    {
        return [
            'Titulo' => $dto->title,
            'Editora' => $dto->publisher,
            'Edicao' => $dto->edition,
            'AnoPublicacao' => $dto->publicationYear,
            'Valor' => $dto->price,
        ];
    }
}
