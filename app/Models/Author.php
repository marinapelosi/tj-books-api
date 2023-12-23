<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasUlids;

    protected $table = 'autores';
    protected $primaryKey = 'CodAu';
    public $incrementing = false;

    protected $fillable = ['Nome'];


    protected $casts = [
        'Nome' => 'string',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'livros_autores', 'Autor_CodAu', 'Livro_Codl');
    }
}
