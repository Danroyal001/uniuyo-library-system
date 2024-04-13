<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Books extends Model
{
    protected $fillable = array('book_id', 'title', 'author', 'category_id', 'description', 'added_by', 'overdue_price', 'lost_price');

    public $timestamps = false;

    protected $table = 'books';
    protected $primaryKey = 'book_id';

    protected $hidden = array();


    protected static function boot()
    {
        parent::boot();

        // Listen for the creating event
        static::creating(function ($book) {
            $book->added_by = Auth::id();
        });
    }


    public function issues()
    {
        return $this::count();
    }

    function bookIssueStock(): BelongsTo
    {
        return $this->belongsTo(BookIssue::class, 'book_id');
    }

    function bookIssues(): HasMany
    {
        return $this->hasMany(Logs::class, 'book_issue_id')->whereStatus('issued');
    }

    function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}