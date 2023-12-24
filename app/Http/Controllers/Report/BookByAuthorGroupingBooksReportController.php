<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class BookByAuthorGroupingBooksReportController extends Controller
{
    public function generateReport(): JsonResponse
    {
        return response()->success(
            __('reports.success_with_view_db'),
            DB::table('report_books_by_author_grouping_by_books_view')->get()
        );
    }
}
