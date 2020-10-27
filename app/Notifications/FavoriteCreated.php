<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FavoriteCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
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
        return (new MailMessage)
                    ->line(__('notification.FavoriteCreatedEmail'))
                    ->action(__('notification.click_here'), url('/'))
                    ->line(__('notification.FavoriteCreatedDescEmail'));
    }


    public function toDatabase($notifiable)
    {
        return [
            'image'=> url('/images/notifications/add.svg'),
            'title'=> __('notification.FavoriteCreated'),
            'desc'=>__('notification.FavoriteCreatedDesc'),
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
