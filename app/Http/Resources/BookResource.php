<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'publicationYear' => $this->AnoPublicacao,
            'price' => str_replace('.', ',', $this->Valor),
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d/m/Y'),
            'authors' => AuthorResource::collection($this->authors),
            'authors_quantity' => $this->authors->count() ?? 0,
            'subjects' => SubjectResource::collection($this->subjects),
            'subjects_quantity' => $this->subjects->count() ?? 0,
        ];
    }
}
