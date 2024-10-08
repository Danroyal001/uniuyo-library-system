<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
	protected $fillable = ['first_name', 'last_name', 'approved', 'category', 'roll_num', 'branch', 'year', 'email', 'status'];

	public $timestamps = false;

	protected $table = 'students';
	protected $primaryKey = 'student_id';

	protected $hidden = [];


	function bookIssues(): HasMany
	{
		return $this->hasMany(Logs::class, 'student_id');
	}


	function scopeFullName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}


	protected static function boot()
	{
		parent::boot();

		// Listen for the creating event
		static::creating(function ($student) {
			$student->roll_num = $student->generateUniqueRollNumber(); // Generate a unique Reg number
		});
	}

	public function generateUniqueRollNumber()
	{
		do {
			$rollNumber = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5); // Generate a random Reg number
		} while (static::where('roll_num', $rollNumber)->exists()); // Check if Reg number already exists

		return $rollNumber;
	}
}
