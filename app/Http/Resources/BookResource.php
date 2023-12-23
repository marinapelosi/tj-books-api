<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->Codl,
            'title' => $this->Titulo,
            'publisher' => $this->Editora,
            'edition' => $this->Edicao,
            'year_publication' => $this->AnoPublicacao,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'authors' => AuthorResource::collection($this->authors),
            'subjects' => SubjectResource::collection($this->subjects),
        ];
    }
}
