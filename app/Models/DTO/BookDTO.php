<?php

namespace App\Models\DTO;

use Illuminate\Database\Eloquent\Model;

class BookDTO extends Model
{
    public string $title;
    public string $publisher;
    public int $edition;
    public int $publicationYear;
    public float|string $price;
    public array $authors;
    public array $subjects;

    protected $fillable = [
        'Titulo',
        'Editora',
        'Edicao',
        'AnoPublicacao',
        'Valor'
    ];

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->title = $data['title'] ?? '';
        $this->publisher = $data['publisher'] ?? '';
        $this->edition = $data['edition'] ?? 0;
        $this->publicationYear = $data['publicationYear'] ?? 0;
        $this->price = $data['price'] ?? 0.0;
        $this->authors = $data['authors'] ?? [];
        $this->subjects = $data['subjects'] ?? [];

        $this->formatPrice();
    }

    public function formatPrice()
    {
        if (!empty($this->price)) {
            $this->price = floatval(str_replace(',', '.', $this->price));
        }
    }
}
