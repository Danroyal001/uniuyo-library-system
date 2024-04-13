<?php

namespace App\Notifications;

use App\Models\Logs;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OverdueBookNotification extends Notification
{
    use Queueable;

    protected $book;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Logs $book)
    {
        $this->book = $book;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($this->book->title && $this->book->id) {
            return (new Mailable)
                ->line('The book "' . $this->book->title . '" is overdue.')
                ->line('Please return it to the library as soon as possible.')
                ->action('View Book', url('/books/' . $this->book->id))
                ->line('Thank you for your attention.');
        } else {
            // Log an error if necessary properties are missing
            Log::error('Invalid book data for overdue notification: ' . json_encode($this->book));
            // Return a default mail message
            return (new MailMessage)
                ->line('A book is overdue. Please check your account for details.');
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}