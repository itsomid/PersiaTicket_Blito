<?php

namespace App\Channels;

use App\Classes\Seeb\SeebPush;
use Illuminate\Notifications\Notification;

class SeebPushChannel
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
        $type = $notification->pushType();
        $message = $notification->toSeebPush($notifiable);



        if(count($message['include_player_ids']) > 0 && $message['include_player_ids'][0] != "")
        {
            $seebPush = new SeebPush(config('services.onesignal')['app_id'],config('services.onesignal')['rest_api_key'],'');
            $seebPush->sendNotificationCustom($message);
        }
        else {
            \Log::alert('no push for user #'.$notifiable->id);
        }
    }
}