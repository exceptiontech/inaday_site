<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class VerifyEmail extends Notification
{
//    use Queueable;



    $verificationUrl = $this->verificationUrl($notifiable);

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }


    // change as you want
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }
        return (new MailMessage)
            ->subject(__('notification.Verify_Email_Address'))
            ->line(__('notification.Please_click_the_button_below_to_verify_your_email_address'))
            ->action(__('notification.Verify_Email_Address'), $verificationUrl)
            ->line(__('notification.If_you_did_not_create__an_account_no_further_action_is_required'));
    }


}
