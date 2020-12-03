<?php

namespace App\Notifications\Database;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReplayCreated extends Notification
{
    use Queueable;

    protected $replay;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($replay)
    {
        $this->replay = $replay;
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
        $url = url('/bookings/'.$this->replay->booking->id);

        return [
            'image'=> url('/images/notifications/approve.svg'),
            'title'=> __('notification.ReplayCreated'),
            'desc'=>__('notification.ReplayCreatedDesc'),
            'url' => $url,
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
