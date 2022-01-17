<?php

namespace App\Channels;

use App\Seeb\SeebPush;
use App\Seeb\shSMS;
use Illuminate\Notifications\Notification;

class SeebTextMessageChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSeebTextMessage($notifiable);
        shSMS::sendSMS($notifiable->mobile,$message);
    }
}