<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Logs extends Model
{
	protected $fillable = array('book_issue_id', 'student_id', 'issue_by', 'issued_at', 'return_time', 'status', 'return_date', 'stock_number');

	// public $timestamps = false;

	protected $table = 'book_issue_logs';
	protected $primaryKey = 'id';

	protected $hidden = array();


	protected function casts(): array
	{
		return [
			'return_date' => 'date',
		];
	}


	function book(): BelongsTo
	{
		return $this->belongsTo(Books::class, 'book_issue_id');
	}


	public function scopeGetBookWithStockNumber()
	{
		// dd($this->load('book'));
		if (!empty($this->book->bookIssueStock->stock_number)) {
			return $this?->book?->title . ' (' . $this->book->bookIssueStock->stock_number . ')';
		}
		return $this?->book?->title;
	}



	function student(): BelongsTo
	{
		return $this->belongsTo(Student::class, 'student_id');
	}
}
