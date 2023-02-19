<?php

namespace App\NotificationChannels;

use Illuminate\Notifications\Notification;
use App\Notification as LegacyNotification;

class LegacyNotificationsTable
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        LegacyNotification::create(
            $notification->toLegacyNotification($notifiable));
    }
}