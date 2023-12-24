<?php

namespace App\Libs;

use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class AuthorFilterLib
{
    private Builder $query;

    public function __construct(
        private readonly ?Collection $filters = null,
        private readonly ?Collection $fields = null
    ) {
        $this->query = Author::query();

        if ($this->fields && $this->fields->isNotEmpty()) {
            $this->query->select($this->fields->toArray());
        }
    }

    public function filter(): static
    {
        $this->filters->each(fn ($filter, $key) => $this->handlerFilter($filter, $key));

        return $this;
    }

    public function orderBy(): static
    {
        $this->query->orderBy('Nome');
        $this->query->orderBy('created_at', 'desc');

        return $this;
    }

    public function withRelations(): static
    {
        $this->query->with('books');

        return $this;
    }


    private function handlerFilter($filter, $key): void
    {
        if (! empty($filter)) {
            $method = 'handle'.ucfirst(($key));

            if (method_exists($this, $method)) {
                $this->$method($filter);
            }
        }
    }

    private function handleName(string $filter): void
    {
        $this->query->where('Nome', 'iLIKE', '%'.$filter.'%');
    }

    public function get(): LengthAwarePaginator
    {
        return $this->query->paginate(20);
    }
}
