<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookSubject extends Model
{
    use HasUlids;

    protected $table = 'livros_assuntos';
    protected $primaryKey = 'Id';
    public $incrementing = false;

    protected $fillable = [
        'Livro_Codl',
        'Assunto_CodAs'
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'LivroCodl', 'Codl');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'AssuntoCodAs', 'CodAs');
    }
}
