<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->CodAs,
            'description' => $this->Descricao
        ];
    }
}
