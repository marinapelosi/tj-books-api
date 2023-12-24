<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'regex' => 'O formato do campo :attribute é inválido.',
    'unique' => 'O valor do campo :attribute já está em uso.',
    'required' => 'O campo :attribute é obrigatório.',
    'max' => [
        'string' => 'O campo :attribute não pode ter mais de :max caracteres.'
    ],

    'custom' => [
        'name' => [
            'required' => 'O campo Nome é obrigatório.',
            'unique' => 'Já existe registro com este nome.'
        ],
        'title' => [
            'required' => 'O campo Título é obrigatório.',
            'max' => 'O Título só pode conter no máximo 40 caracteres.'
        ],
        'publisher' => [
            'required' => 'O campo Editora é obrigatório.',
            'max' => 'A Editora só pode conter no máximo 40 caracteres.'
        ],
        'edition' => [
            'required' => 'O campo Edição é obrigatório.',
            'integer' => 'A Edição deve ser um dado numérico'
        ],
        'publicationYear' => [
            'required' => 'O campo Ano de Publicação é obrigatório.',
            'integer' => 'Ano de Publicação é um campo numérico',
            'numeric' => 'Insira um Ano de Publicação válido.',
            'min' => 'Insira um Ano de Publicação válido.',
            'max' => 'Insira um Ano de Publicação válido.'
        ],
        "price" => [
            'required' => 'É necessário informar o preço do livro',
            'numeric' => 'O campo Preço deve ser em reais',
            'regex' => 'O campo Preço deve ser em reais'
        ],
        "authors" => [
            'required' => 'Você deve informar uma lista contendo um ou mais autores deste livro.',
            'array' => 'Você deve informar uma lista contendo um ou mais autores deste livro.'
        ],
        "authors.*" => [
            'exists' => 'Você só pode associar ao livro autores já cadastrados no sistema'
        ],
        "subjects" => [
            'required' => 'Você deve informar uma lista contendo um ou mais assuntos deste livro.',
            'array' => 'Você deve informar uma lista contendo um ou mais assuntos deste livro.',
            'exists' => 'Você só pode associar ao livro assuntos já cadastrados no sistema'
        ],
        "subjects.*" => [
            'exists' => 'Você só pode associar ao livro assuntos já cadastrados no sistema'
        ],
    ],
];
