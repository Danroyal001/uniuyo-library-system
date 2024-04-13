<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BookIssue extends Model
{
    protected $fillable = ['added_by', 'available_status', 'book_id'];

    public $timestamps = false;

    protected $primaryKey = 'issue_id';

    protected $hidden = [];

    protected static function boot()
    {
        parent::boot();

        // On creating a new book issue, generate a unique stock number
        static::creating(function ($bookIssue) {
            $bookIssue->stock_number = static::generateUniqueStockNumber();
            $bookIssue->added_by = Auth::id();
        });
    }

    private static function generateUniqueStockNumber()
    {
        do {
            $stockNumber = static::generateRandomStockNumber(); // Generate a random stock number

            // Check if the generated stock number already exists in the database
            $existingBookIssue = static::where('stock_number', $stockNumber)->first();
        } while ($existingBookIssue);

        return $stockNumber;
    }


    private static function generateRandomStockNumber()
    {
        // Implement your logic to generate a random stock number
        // For example:
        return 'BS' . rand(1000, 9999); // Generates a stock number in the format BSXXXX
    }
}
