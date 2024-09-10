<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\VoucherCode;

class WelcomeEmail extends Notification
{
    use Queueable;

    private $voucherCode;

    /**
     * Create a new notification instance.
     */
    public function __construct(VoucherCode $voucherCode)
    {
        $this->voucherCode = $voucherCode;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Here is your voucher!')
                    ->line('Your voucher code is: ')
                    ->line('$this->voucherCode->code');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
