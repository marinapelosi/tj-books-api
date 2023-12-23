<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasUlids;

    protected $table = 'assuntos';
    protected $primaryKey = 'CodAs';
    public $incrementing = false;

    protected $fillable = ['Descricao'];

    protected $casts = [
        'Descricao' => 'string',
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'livro_assuntos', 'Assunto_CodAs', 'Livro_Codl');
    }
}
