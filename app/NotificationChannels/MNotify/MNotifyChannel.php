<?php

namespace App\NotificationChannels\MNotify;

use App\NotificationChannels\MNotify\MNotifyMessage;
use Illuminate\Notifications\Notification;
use PatricPoba\MnotifySms;

class MNotifyChannel
{
    /**
     * @var MnotifySms  A beautiful wrapper for mNotify written
     *                  by our very own Patric Poba.
     */
    protected $sms;

    public function __construct(MnotifySms $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return \App\NotificationChannels\MNotify\MNotifyMessage
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toMNotify($notifiable);

        if (is_string($message)) {
            $message = new MNotifyMessage($message);
        }

        if ($message->from) {
            $this->sms->from($message->from);
        }

        return $this->sms->send(($notification->phone ?: $notifiable->phone), trim($message->content));
    }
}
