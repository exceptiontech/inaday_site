<?php

namespace App\Notifications\Database;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MixtureRefused extends Notification
{
    use Queueable;

    protected $mixture;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mixture)
    {
        $this->mixture = $mixture;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }



    public function toDatabase($notifiable)
    {

        $url = url('/account/mixtures/'.$this->mixture->id.'/edit');

        return [
            'image'=> url('/images/notifications/refuse.svg'),
            'title'=> __('notification.MixtureRefused'),
            'desc'=>__('notification.MixtureRefusedDesc'),
            'url'=> $url,
        ];
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
