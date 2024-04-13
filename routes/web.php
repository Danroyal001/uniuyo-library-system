<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentController;



Route::get('/', function () {
    return view('welcome');
});

// Define authentication routes
// Auth::routes();

// Unauthenticated routes 
Route::middleware('guest')->group(function () {

    Route::post('/create', [AccountController::class, 'postCreate'])->name('account-create-post');

    // Sign in (POST) 
    Route::post('/sign-in', [AccountController::class, 'postSignIn'])->name('account-sign-in-post');

    // Sign in (GET) 
    Route::get('/', [AccountController::class, 'getSignIn'])->name('account-sign-in');
    Route::get('/login', [AccountController::class, 'getSignIn'])->name('login');

    // Create an account (GET) 
    Route::get('/create', [AccountController::class, 'getCreate'])->name('account-create');


    // Student Registration (POST) 
    Route::post('/student-registration', [StudentController::class, 'postRegistration'])->name('student-registration-post');
    // Student Registration form 
    Route::get('/student-registration', [StudentController::class, 'getRegistration'])->name('student-registration');

    // Render search books panel
    Route::get('/book', [BooksController::class, 'searchBook'])->name('search-book');
});

// Main books Controller left public so that it could be used without logging in too
Route::resource('/books', BooksController::class);
Route::get('/book-search/{string}', [BooksController::class, 'searchDasboardBook'])->name('book-search');


// Authenticated routes 
Route::middleware('auth')->group(function () {
    // Home Page of Control Panel
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/fetch-most-borrowed-books', [HomeController::class, 'fetchMostBorrowedBooks'])->name('home.chart');


    // Render Add Books panel
    Route::get('/student-issue-books/{userId}', [BooksController::class, 'displayStudentIssuedBooks'])->name('student-issue-books');
    Route::get('/add-books', [BooksController::class, 'renderAddBooks'])->name('add-books');
    Route::get('/edit-books/{id}/edit', [BooksController::class, 'renderEditBooks'])->name('edit-books');
    Route::delete('/delete-books/{id}', [BooksController::class, 'deleteBook'])->name('delete-books');

    Route::get('/add-book-category', [BooksController::class, 'renderAddBookCategory'])->name('add-book-category');
    Route::post('/bookcategory', [BooksController::class, 'BookCategoryStore'])->name('bookcategory.store');

    // Render All Books panel
    Route::get('/all-books', [BooksController::class, 'renderAllBooks'])->name('all-books');

    Route::get('/bookBycategory/{cat_id}', [BooksController::class, 'BookByCategory'])->name('bookBycategory');

    // Students
    Route::get('/all-students/{slug?}', [StudentController::class, 'renderStudents'])->name('all-students');

    // Render students approval panel
    Route::get('/students-for-approval', [StudentController::class, 'renderApprovalStudents'])->name('students-for-approval');

    // Render settings panel
    Route::get('/settings/{slug?}', [SettingController::class, 'renderSetting'])->name('settings');
    Route::post('/setting', [SettingController::class, 'StoreSetting'])->name('settings.store');
    Route::delete('/delete-setting/{id}', [SettingController::class, 'deleteSetting'])->name('settings.delete');

    // Main students Controller resource
    Route::resource('/student', StudentController::class);

    Route::get('/getStudentByAttribute', [StudentController::class, 'StudentByAttribute'])->name('getStudentByAttribute');

    // Issue Logs
    Route::get('/issue-return', [LogController::class, 'renderIssueOrReturnBook'])->name('issue-return');
    // Render logs panel
    Route::get('/currently-issued', [LogController::class, 'renderLogs'])->name('currently-issued');
    // Main Logs Controller resource
    Route::resource('/issue-log', LogController::class);

    // Sign out (GET) 
    Route::get('/sign-out', [AccountController::class, 'getSignOut'])->name('account-sign-out');
});
