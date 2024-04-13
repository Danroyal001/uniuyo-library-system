<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Books;

use App\Models\Branch;

use App\Models\BookIssue;
use App\Models\Categories;
use App\Models\Logs;
use Illuminate\Http\Request;
use App\Models\StudentCategory;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public $categories_list = [];
    public $branch_list = [];
    public $student_categories_list = [];

    public function __construct()
    {
        $this->categories_list = Categories::orderBy('category')->get();
        $this->branch_list = Branch::orderBy('id')->get();
        $this->student_categories_list = StudentCategory::orderBy('cat_id')->get();
    }

    public function home()
    {

        $mostBorrowedBooks = Logs::select(
            DB::raw("DATE_FORMAT(book_issue_logs.created_at, '%b %Y') AS month"),
            'books.title',
            DB::raw('COUNT(*) as borrow_count')
        )
            ->join('books', 'book_issue_logs.book_issue_id', '=', 'books.book_id')
            ->groupBy('month', 'books.title')
            ->orderBy('month')
            ->orderByDesc('borrow_count')
            ->get();


        // dd($mostBorrowedBooks);

        // Stock alerts (books with low stock)
        // $stockAlerts = Books::where('stock_alert', '<=', 5)->get();
        $stockAlerts = Books::where('stock_alert', '<=', 5)->select('title', 'stock_alert')->get();


        // return view('statistics', compact('mostBorrowedBooks', 'stockAlerts'));

        // return view('panel.dashboard.index')
        return view('panel.index')
            ->with('categories_list', $this->categories_list)
            ->with('branch_list', $this->branch_list)
            ->with('student_categories_list', $this->student_categories_list)
            ->with('mostBorrowedBooks', $mostBorrowedBooks)
            ->with('stockAlerts', $stockAlerts);
    }

    public function fetchMostBorrowedBooks()
    {
        $mostBorrowedBooks = Logs::select(
            DB::raw("DATE_FORMAT(book_issue_logs.created_at, '%b %Y') AS month"),
            'books.title',
            DB::raw('COUNT(*) as borrow_count')
        )
            ->join('books', 'book_issue_logs.book_issue_id', '=', 'books.book_id')
            ->groupBy('month', 'books.title')
            ->orderBy('month')
            ->orderByDesc('borrow_count')
            ->get();

        return response()->json($mostBorrowedBooks);
    }
}