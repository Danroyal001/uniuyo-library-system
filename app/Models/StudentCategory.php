<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentCategory extends Model
{
	protected $fillable = array('cat_id', 'category', 'max_allowed');

	public $timestamps = false;

	protected $primaryKey = 'cat_id';

	protected $hidden = array();
}
