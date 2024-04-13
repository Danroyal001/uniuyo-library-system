<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Books;
use App\Models\BookIssue;
use App\Models\Branch;
use App\Models\Student;
use App\Models\Categories;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\BookCategories;
use App\Models\StudentCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

class BooksController extends Controller
{

	public function index()
	{

		$book_list = Books::select('book_id', 'title', 'author', 'description', 'book_categories.category')
			->join('book_categories', 'book_categories.id', '=', 'books.category_id')
			->orderBy('book_id')->get();

		for ($i = 0; $i < count($book_list); $i++) {

			$id = $book_list[$i]['book_id'];
			$conditions = array(
				'book_id'			=> $id,
				'available_status'	=> 1
			);

			$book_list[$i]['total_books'] = BookIssue::select()
				->where('book_id', '=', $id)
				->count();

			$book_list[$i]['avaliable'] = BookIssue::select()
				->where($conditions)
				->count();
		}

		return $book_list;
	}



	public function store(Request $request)
	{
		$validatedData = $request->validate([
			'bookId' => 'nullable|integer|exists:books,book_id',
			'title' => 'required|string',
			'author' => 'required|string',
			'description' => 'required|string',
			'category_id' => 'required|integer',
			'number' => 'required|integer|min:1',
			'overdue_price' => 'required|integer|min:0',
			'lost_price' => 'required|integer|min:0',
		]);

		try {
			DB::beginTransaction();

			// Create or update the book
			$book = Books::updateOrCreate(['book_id' => $request->bookId], Arr::except($validatedData, ['number']));

			if (!$book) {
				DB::rollBack();
				return 'Failed to add book to the database';
			}

			$number_of_issues = $request->input('number');

			// Create issues for the book
			for ($i = 0; $i < $number_of_issues; $i++) {
				$issue = BookIssue::create(['book_id' => $book->book_id]);

				if (!$issue) {
					DB::rollBack();
					return 'Failed to create book issue';
				}
			}

			DB::commit();

			return 'Books added successfully to the database';
		} catch (\Exception $e) {
			DB::rollBack();
			return 'Failed to add books to the database: ' . $e->getMessage();
		}
	}


	public function BookCategoryStore(Request $request)
	{

		// dd($request->all());
		if ($request->has('delete')) {
			$bookcategory = BookCategories::find($request->category_id)->delete();
		} else {
			$bookcategory = BookCategories::updateOrCreate(['id' => $request->category_id], $request->except('category_id'));
		}

		if (!$bookcategory) {

			return 'Book Category fail to save!';
		} else {

			return "Book Category Added successfully to Database";
		}
	}

	function searchDasboardBook($search)
	{
		$book_list = Books::select('book_id', 'title', 'author', 'description', 'book_categories.category')
			->join('book_categories', 'book_categories.id', '=', 'books.category_id')
			->where(function ($query) use ($search) {
				$query->where('title', 'like', '%' . $search . '%')
					->orWhere('author', 'like', '%' . $search . '%');
			})
			->orderBy('book_id');

		$book_list = $book_list->get();

		foreach ($book_list as $book) {
			$conditions = array(
				'book_id'			=> $book->book_id,
				'available_status'	=> 1
			);

			$count = BookIssue::where($conditions)
				->count();

			$book->avaliability = ($count > 0) ? true : false;
		}

		return $book_list;
	}


	public function show($string)
	{
		$book_list = Books::select('book_id', 'title', 'author', 'description', 'book_categories.category')
			->join('book_categories', 'book_categories.id', '=', 'books.category_id')
			->where(function ($query) use ($string) {
				$query->where('title', 'like', '%' . $string . '%')
					->orWhere('author', 'like', '%' . $string . '%');
			})
			->orderBy('book_id');

		$book_list = $book_list->get();

		foreach ($book_list as $book) {
			$conditions = array(
				'book_id'			=> $book->book_id,
				'available_status'	=> 1
			);

			$count = BookIssue::where($conditions)
				->count();

			$book->avaliability = ($count > 0) ? true : false;
		}

		return $book_list;
	}


	public function edit($id)
	{
		// dd($id);
		$issue = BookIssue::find($id);
		if ($issue == NULL) {
			return 'Invalid Book ID';
		}

		$book = Books::find($issue->book_id);

		$issue->book_name = $book->title;
		$issue->author = $book->author;

		$issue->category = Categories::find($book->category_id)
			->category;

		$issue->available_status = (bool)$issue->available_status;
		if ($issue->available_status == 1) {
			return $issue;
		}

		$conditions = array(
			'return_time'	=> 0,
			'book_issue_id'	=> $id,
		);
		$book_issue_log = Logs::where($conditions)
			->take(1)
			->get();

		foreach ($book_issue_log as $log) {
			$student_id = $log->student_id;
		}

		$student_data = Student::find($student_id);

		unset($student_data->email);
		unset($student_data->books_issued);
		unset($student_data->approved);
		unset($student_data->rejected);

		$student_branch = Branch::find($student_data->branch)
			->branch;
		$roll_num = $student_data->roll_num . '/' . $student_branch . '/' . substr($student_data->year, 2, 4);

		unset($student_data->roll_num);
		unset($student_data->branch);
		unset($student_data->year);

		$student_data->roll_num = $roll_num;

		$student_data->category = StudentCategory::find($student_data->category)
			->category;
		$issue->student = $student_data;


		return $issue;
	}


	public function deleteBook($id)
	{
		try {
			DB::beginTransaction();

			// Find the book to delete
			$book = Books::find($id);

			if (!$book) {
				DB::rollBack();
				return response()->json(['type' => 'error', 'message' => 'Book not found']);
			}

			// dd($book->bookIssues()->exists());
			// Check if the book has any associated issues
			if ($book->bookIssues()->exists()) {
				DB::rollBack();
				return response()->json(['type' => 'info', 'message' => 'Cannot delete book. It has already been issued.']);
			}
			// dd($book->bookIssues()->exists());

			// Delete the book
			$book->delete();

			DB::commit();
			return response()->json(['type' => 'success', 'message' => 'Book deleted successfully']);
		} catch (\Exception $e) {
			DB::rollBack();
			return 'Failed to delete book: ' . $e->getMessage();
		}
	}

	public function renderAddBookCategory()
	{

		if (request()->ajax()) {
			$book_categories = Categories::select('id', 'category')->get();
			return $book_categories;
		}

		return view('panel.addbookcategory');
	}


	public function renderAddBooks()
	{
		$db_control = new HomeController();

		return view('panel.addbook')
			->with('categories_list', $db_control->categories_list);
	}

	public function renderEditBooks($id)
	{
		$book = Books::find($id);

		$db_control = new HomeController();

		return view('panel.addbook', [
			'categories_list' => $db_control->categories_list,
			'book' => $book
		]);
	}


	public function renderAllBooks()
	{
		$db_control = new HomeController();

		return view('panel.allbook')
			->with('categories_list', $db_control->categories_list);
	}

	public function BookByCategory($cat_id)
	{
		$book_list = Books::select('book_id', 'title', 'author', 'description', 'book_categories.category')
			->join('book_categories', 'book_categories.id', '=', 'books.category_id')
			->where('category_id', $cat_id)->orderBy('book_id');

		$book_list = $book_list->get();

		for ($i = 0; $i < count($book_list); $i++) {

			$id = $book_list[$i]['book_id'];
			$conditions = array(
				'book_id'			=> $id,
				'available_status'	=> 1
			);

			$book_list[$i]['total_books'] = BookIssue::select()
				->where('book_id', '=', $id)
				->count();

			$book_list[$i]['avaliable'] = BookIssue::select()
				->where($conditions)
				->count();
		}

		return $book_list;
	}

	public function searchBook()
	{
		$db_control = new HomeController();

		return view('public.book-search')
			->with('categories_list', $db_control->categories_list);
	}

	public function renderIssueOrReturnBook()
	{
		return view('panel.issue-return');
	}

	public function displayStudentIssuedBooks($userId)
	{
		$student = Student::find($userId);

		// Assuming $userId is the ID of the user whose issued books you want to display
		$issuedBooks = $student->bookIssues()->with('book')->whereStatus('issued')->get();

		// dd($issuedBooks);

		return view('panel.students.all_issues', compact('issuedBooks', 'student'));
	}
}
