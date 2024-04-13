<?php

namespace App\Console\Commands;

use App\Mail\OverdueBookMail;
use App\Models\Logs;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Notifications\OverdueBookNotification;

class CheckOverdueBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-overdue-books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Find overdue books
        $overdueBooks = Logs::where('return_date', '<', Carbon::now())
            ->where('status', 'issued')
            ->get();

        // Update status to 'overdue' and send email
        foreach ($overdueBooks as $book) {
            $book->status = 'overdue';
            $book->save();

            // Send email notification
            $studentEmail = $book->student->email; // Assuming there's a relationship to student
            Mail::to($studentEmail)->send(new OverdueBookMail($book));
        }
    }
}
