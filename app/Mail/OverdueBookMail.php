<?php

namespace App\Mail;

use App\Models\Logs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OverdueBookMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $book;

    /**
     * Create a new message instance.
     *
     * @param Logs $book
     */
    public function __construct(Logs $book)
    {
        $this->book = $book;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Overdue Book Notification')
            ->view('emails.overdue-book')
            ->with([
                'studentName' => $this->book->student->fullname(),
                'bookTitle' => $this->book->book->title,
                'bookId' => $this->book->book_issue_id,
            ]);
    }
}
