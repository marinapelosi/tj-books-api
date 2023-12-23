<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasUlids;

    protected $table = 'livros';
    protected $primaryKey = 'Codl';
    public $incrementing = false;

    protected $fillable = [
        'Titulo',
        'Editora',
        'Edicao',
        'AnoPublicacao',
        'Valor'
    ];


    protected $casts = [
        'Edicao' => 'integer',
        'AnoPublicacao' => 'integer',
        'Valor' => 'decimal:2',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'livros_autores', 'Livro_Codl', 'Autor_CodAu');
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'livros_assuntos', 'Livro_Codl', 'Assunto_CodAs');
    }
}
