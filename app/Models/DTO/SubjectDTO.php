<?php

namespace App\Models\DTO;

use Illuminate\Database\Eloquent\Model;

class SubjectDTO extends Model
{
    public string $description;

    protected $fillable = ['description'];

    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->description = $data['description'] ?? '';
    }
}
