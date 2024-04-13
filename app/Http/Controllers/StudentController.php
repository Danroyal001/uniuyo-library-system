<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Logs;
use App\Models\Books;
use App\Models\BookIssue;
use App\Models\Branch;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentCategory;
use Illuminate\Support\Facades\Redirect;


class StudentController extends Controller
{
	public $filter_params;

	public function __construct()
	{
		$this->filter_params = ['branch', 'year', 'category'];
	}

	public function index(Request $request)
	{
		return $this->getStudentsByStatus($request);
	}

	public function StudentByAttribute(Request $request)
	{
		// $conditions = ['approved' => $request->flag ?? 0, 'rejected' => 0];
		return $this->getStudentsByStatus($request);
	}

	public function create()
	{
		return $this->getStudentsByStatus(['approved' => 1, 'rejected' => 0]);
	}


	public function show($id)
	{
		$student = Student::find($id);

		if (!$student) {
			throw new Exception('Invalid Student ID');
		}

		$student->year = (int) substr($student->year, 2, 4);
		$student->category = StudentCategory::find($student->category)->category;
		$student->branch = Branch::find($student->branch)->branch;

		$student = $this->processStudentData($student, $id);

		return $student;
	}

	public function update(Request $request, $id)
	{
		$flag = $request->flag;
		$student = Student::findOrFail($id);
		$student->status = $flag;
		$student->save();
		return 'Student\'s approval/rejection status successfully changed.';
	}

	public function destroy(Request $request, $id)
	{
		if ($request->category) {
			$model = StudentCategory::find($id);
		} elseif ($request->branch) {
			$model = Branch::find($id);
		}
		$model->delete();
		return $model ? redirect()->route('settings') : 'Fail to Delete!';
	}

	public function renderStudents()
	{
		return $this->renderView('panel.students');
	}

	public function renderApprovalStudents()
	{
		return $this->renderView('panel.approval');
	}

	public function getRegistration()
	{
		return $this->renderView('public.registration');
	}

	public function postRegistration(Request $request)
	{
		$validator = $request->validate([
			'first' => 'required|alpha',
			'last' => 'required|alpha',
			'rollnumber' => 'required|string',
			'branch' => 'required|between:0,10',
			'year' => 'required|integer',
			'email' => 'required|email',
			'category' => 'required|between:0,5'
		]);

		if ($validator) {
			$student = Student::create([
				'first_name' => $request->first,
				'last_name' => $request->last,
				'category' => $request->category,
				'roll_num' => $request->rollnumber,
				'branch' => $request->branch,
				'year' => $request->year,
				'email' => $request->email,
				'status' => 'new',
			]);

			if ($student) {
				return redirect()->route('student-registration')->with('global', 'Your request has been raised, you will be soon approved!');
			}
		} else {
			return Redirect::route('student-registration')->withErrors($validator)->withInput();
		}
	}

	public function getStudentsByStatus($request)
	{
		$status = $request['status'] ?? 'all';

		$students =	$this->getStudentsByStatusForTable($status, $request);

		return $students->isEmpty() ? 'No Result Found' : $students;
	}

	protected function getStudentsByStatusForTable($status, $request)
	{
		$query = Student::join('branches', 'branches.id', '=', 'students.branch')
			->join('student_categories', 'student_categories.cat_id', '=', 'students.category')
			->select('student_id', 'first_name', 'last_name', 'student_categories.category', 'roll_num', 'branches.branch', 'year', 'email', 'books_issued');

		$query->whereStatus($status);

		$query = $this->applyFilters($query, $request);

		return $query->orderBy('student_id')->get();
	}


	protected function applyFilters($query, $request)
	{
		return $query->when($request?->branch != 0, function ($query) use ($request) {
			return $query->where('students.branch', $request->branch);
		})
			->when($request?->category != 0, function ($query) use ($request) {
				return $query->where('students.category', $request->category);
			})
			->when($request?->year != 0, function ($query) use ($request) {
				return $query->where('students.year', $request->year);
			});
	}

	protected function processStudentData($student, $id)
	{
		$student->year = (int) substr($student->year, 2, 4);
		$student->category = StudentCategory::find($student->category)->category;
		$student->branch = Branch::find($student->branch)->branch;

		if ($student->rejected == 1) {
			unset($student->approved, $student->books_issued);
			$student->rejected = (bool) $student->rejected;
		} elseif ($student->approved == 0) {
			unset($student->rejected, $student->books_issued);
			$student->approved = (bool) $student->approved;
		} else {
			unset($student->rejected, $student->approved);

			$student_issued_books = Logs::select('book_issue_id', 'issued_at')
				->where('student_id', $id)
				->orderByDesc('created_at')
				->take($student->books_issued)
				->get();

			foreach ($student_issued_books as $issued_book) {
				$issue = BookIssue::find($issued_book->book_issue_id);
				$book = Books::find($issue->book_id);
				$issued_book->name = $book->title;
				$issued_book->issued_at = date('d-M', strtotime($issued_book->issued_at));
			}

			$student->issued_books = $student_issued_books;
		}

		return $student;
	}


	protected function renderView($view)
	{
		$db_control = new HomeController;
		return view($view)
			->with('branch_list', $db_control->branch_list)
			->with('student_categories_list', $db_control->student_categories_list);
	}
}
