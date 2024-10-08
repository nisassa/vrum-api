<?php

namespace App\Notifications\Bookings;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Mail\Bookings\BookingCreated;
use App\Models\Booking;
use App\NotificationChannels\LegacyNotificationsTable;
use App\Models\NotificationTargetType;

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
            'user_id' => $notifiable->id,
            'target_id' => $this->booking->id,
            'target_table' => $this->booking->getTable(),
            'target_sub_type_id' => NotificationTargetType::NEW_BOOKING_RECEIVED_ID,
            'payload' => json_encode([
                'message' => 'You received a new booking request for: '. $this->booking->preferred_date->format('dd-mm-yyyy H:i'). '. Booking Number: #'.$this->booking->id
            ]),
            'created' => now(),
        ];
    }
}
