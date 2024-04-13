<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Books;
use App\Models\BookIssue;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
	public function index(Request $request)
	{
		$logs = Logs::select('id', 'book_issue_id', 'student_id', 'issued_at', 'status', 'return_date')
			->when($request?->status, function ($query) use ($request) {
				return $query->whereStatus($request->status);
			})
			->orderBy('issued_at', 'DESC')
			->get();

		foreach ($logs as $log) {
			$issue = BookIssue::find($log->book_issue_id);
			$book = Books::find($issue->book_id);
			$log->book_name = $book->title;

			$log->student_name = $log->student->fullname();
			$log->status = $log->status;

			$log->issued_at = date('d-M Y', strtotime($log->issued_at));
			$log->returnDate = $log->return_date?->format('d-M Y');
			$log->fin = $log->book?->lost_price;
			$log->overdue = $log->book?->overdue_price;
		}

		return $logs;
	}

	public function store(Request $request)
	{
		$data = $request->input('data');
		$bookID = $data['bookID'];
		$studentID = $data['studentID'];
		$bookReturnDate = $data['returnDate'];

		$student = Student::find($studentID);

		if (!$student) {
			return "Invalid Student ID";
		} else {
			$approved = $student->status === 'approved' ? 1 : 0;

			if (!$approved) {
				return "Student still not approved by Admin Librarian";
			} else {
				// Check if student can issue more books
				$books_issued = $student->books_issued;
				$category = $student->category;
				$max_allowed = StudentCategory::where('cat_id', $category)->firstOrFail()->max_allowed;

				if ($books_issued >= $max_allowed) {
					return 'Student cannot issue any more books';
				} else {
					// Check if book is available for issue
					$book = BookIssue::where('book_id', $bookID)->where('available_status', '!=', 0)->first();
					if (!$book) {
						return 'Invalid Book BookIssue ID';
					} else {
						$book_availability = $book->available_status;
						if ($book_availability != 1) {
							return 'Book not available for issue';
						} else {
							// Book is to be issued
							DB::transaction(function () use ($bookID, $studentID, $student, $bookReturnDate) {

								$book_issue_update = BookIssue::where('book_id', $bookID)->where('available_status', '!=', 0)->first();

								$log = new Logs;
								$log->book_issue_id = $bookID;
								$log->student_id = $studentID;
								$log->issue_by = Auth::id();
								$log->issued_at = now();
								$log->return_time = 0;
								$log->status = 'issued';
								$log->return_date = $bookReturnDate;
								$log->stock_number = $book_issue_update->stock_number;
								$log->save();

								// Change the availability status of the book
								$book_issue_update->available_status = 0;
								$book_issue_update->save();

								// Increase number of books issued by student
								$student->books_issued += 1;
								$student->save();
							});

							return 'Book Issued Successfully!';
						}
					}
				}
			}
		}
	}


	public function edit(Request $request, $id)
	{
		// Extract status from the request
		$status = $request->status;
		$issueID = $id;
		$conditions = [
			'id' => $issueID,
		];

		// Find the log based on conditions
		$log = Logs::where($conditions);

		// Check if the log exists
		if (!$log->exists()) {
			return 'Invalid Book ID entered or book already returned';
		}

		try {
			// Retrieve the log
			$log = $log->firstOrFail();

			// Start a database transaction
			DB::transaction(function () use ($log, $status) {
				// Update log's status and, if necessary, return date
				if ($status === 'available') {
					$log->return_date = now();
				}

				$log->status = $status;
				$log->save();

				// Adjust student's book issue counter and issue's availability status
				if ($status === 'available') {
					$student = Student::find($log->student_id);
					$student->books_issued -= 1;
					$student->save();

					$issue = BookIssue::find($log->book_issue_id);
					$issue->available_status = 1;
					$issue->save();
				}
			});

			return 'Successfully updated log';
		} catch (\Exception $e) {
			// Handle any exceptions
			return 'Error: ' . $e->getMessage();
		}
	}


	public function renderLogs()
	{
		return view('panel.logs');
	}

	public function renderIssueOrReturnBook()
	{
		return view('panel.issue-return');
	}
}
