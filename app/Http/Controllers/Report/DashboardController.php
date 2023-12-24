<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\SubjectResource;
use App\Libs\BookFilterLib;
use App\Models\Author;
use App\Models\Book;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Ramsey\Collection\Collection;

class DashboardController extends Controller
{
    public function generateReport(): JsonResponse
    {
        $dashboard = [
            'counters' => $this->getCounters(),
            'top_fives' => $this->getTopFives(),
            'last_books' => $this->getLastBooks(5)
        ];
        return response()->success(
            __('reports.success_dashboard'),
            $dashboard
        );
    }

    public function generateCountersReport(): JsonResponse
    {
        return response()->success(
            __('reports.success_dashboard_counters'),
            $this->getCounters()
        );
    }

    public function generateTopFivesReport(): JsonResponse
    {
        return response()->success(
            __('reports.success_dashboard_top_fives'),
            $this->getTopFives()
        );
    }

    public function generateLastBooksReport(): JsonResponse
    {
        return response()->success(
            __('reports.success_dashboard_last_books'),
            $this->getLastBooks(5)
        );
    }

    public function getCounters(): array
    {
        return [
          'books' => Book::count() ?? 0,
          'authors' => Author::count() ?? 0,
          'subjects' => Subject::count() ?? 0,
          'sum_books_prices' => str_replace('.', ',', (float) Book::sum('Valor'))
        ];
    }

    public function getTopFives(): array
    {
        return [
            'authors' => AuthorResource::collection(Author::withCount('books')
            ->orderByDesc('books_count')
                ->limit(5)
                ->get()),
            'subjects' => SubjectResource::collection(Subject::withCount('books')
            ->orderByDesc('books_count')
                ->limit(5)
                ->get()),
        ];
    }

    public function getLastBooks(int $limit): ResourceCollection
    {
        return BookResource::collection(
            (new BookFilterLib())
                ->withRelations()
                ->orderBy()
                ->limit($limit)
                ->get()
        );
    }
}
