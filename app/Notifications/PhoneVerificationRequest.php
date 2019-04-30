<?php

namespace App\Notifications;

use App\NotificationChannels\MNotify\MNotifyChannel;
use App\NotificationChannels\MNotify\MNotifyMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PhoneVerificationRequest extends Notification
{
    use Queueable;

    /**
     * The verification code in this message.
     *
     * @var int
     */
    protected $code;

    /**
     * The phone number to which the sms will be sent.
     *
     * @var string
     */
    public $phone;

    /**
     * Create a new notification instance.
     *
     * @param int    $code  The 4 digit verification code
     * @param string $phone The phone number to send the code to.
     *
     * @return void
     */
    public function __construct(int $code, string $phone)
    {
        $this->code = $code;

        $this->phone = $phone;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [MNotifyChannel::class];
    }

    /**
     * Get the mNotify representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return Illuminate\Notifications\Messages\MailMessage
     */
    public function toMNotify($notifiable)
    {
        $ttl_mins = (int) config('payplux.phone.code_ttl') / 60;

        return (new MNotifyMessage)
            ->content(
                "Hi {$notifiable->full_name}, " .
                "Your phone number activation code is {$this->code}. Valid for {$ttl_mins} minutes"
            );
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
