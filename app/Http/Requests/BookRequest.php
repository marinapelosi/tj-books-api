<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string',
            'publisher' => 'required|string',
            'edition' => 'required|integer',
            'publicationYear' => 'required|integer|min:1850|max:' . date('Y'),
            'price' => 'required|regex:/^\d+([\.,]\d{1,2})?$/',
            'authors' => 'required|array',
            'authors.*' => 'exists:autores,CodAu',
            'subjects' => 'required|array',
            'subjects.*' => 'exists:assuntos,CodAs',
        ];
    }
}
