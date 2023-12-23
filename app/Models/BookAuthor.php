<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookAuthor extends Model
{
    use HasUlids;

    protected $table = 'livros_autores';
    protected $primaryKey = 'Id';
    public $incrementing = false;

    protected $fillable = [
        'Livro_Codl',
        'Autor_CodAu'
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'Livro_Codl', 'Codl');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'Autor_CodAu', 'CodAu');
    }
}
