<?php

namespace App\Notifications\Bookings;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Mail\Bookings\BookingCreated;
use App\Models\Booking;

class NewBookingCreatedToProvider extends Notification
{
    use Queueable;

    public Booking $booking;

    /**
     * @return void
     */
    public function __construct(Booking $booking)
    {   
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [LegacyNotificationsTable::class, 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new BookingCreated($notifiable, $this->booking))->to($notifiable->email);
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

     /**
     * Get the array representation of the legacy notification data
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toLegacyNotification($notifiable)
    {
        return [
            // 'user_id' => $this->viewber->id,
            // 'target_id' => $this->invitation->id,
            // 'target_table' => $this->invitation->getTable(),
            'created' => now(),
        ];
    }
}
