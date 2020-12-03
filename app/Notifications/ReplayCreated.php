<?php

namespace App\Notifications;

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
        return explode(',', $notifiable->notification_preference);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/bookings/'.$this->replay->booking->id);

        return (new MailMessage)
                    ->line(__('notification.ReplayCreatedEmail'))
                    ->action(__('notification.click_here'), $url )
                    ->line(__('notification.ReplayCreatedDescEmail'));
    }



    public function toDatabase($notifiable)
    {
        return [
            'image'=> url('/images/notifications/approve.svg'),
            'title'=> __('notification.ReplayCreated'),
            'desc'=>__('notification.ReplayCreatedDesc'),
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
