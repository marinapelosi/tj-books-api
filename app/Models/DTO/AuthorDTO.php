<?php

namespace App\Models\DTO;

use Illuminate\Database\Eloquent\Model;

class AuthorDTO extends Model
{
    public string $name;
    protected $fillable = ['name'];

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->name = $data['name'] ?? '';
    }
}
