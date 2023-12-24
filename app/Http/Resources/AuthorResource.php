<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->CodAu,
            'name' => $this->Nome,
            'books_quantity' => $this->books->count() ?? 0,
            'books' => BookResourceWithoutAuthors::collection($this->books),
        ];
    }
}
