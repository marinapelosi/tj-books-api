<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => 'required|unique:assuntos,Descricao|regex:/^[a-zA-ZÀ-ÖØ-öø-ÿ\s\-]+$/u|max:20',
        ];
    }
}
