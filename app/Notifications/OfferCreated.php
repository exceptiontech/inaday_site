<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfferCreated extends Notification
{
    use Queueable;

    protected $offer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($offer)
    {
        $this->offer = $offer;
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
        $url = url('/projects/'.$this->offer->project->id);

        return (new MailMessage)
                    ->line(__('notification.OfferCreatedEmail'))
                    ->line(__('notification.OfferCreatedDescEmail'))
                    ->action(__('notification.click_here'),  $url );
    }



    public function toDatabase($notifiable)
    {
        return [
            'image'=> url('/images/notifications/update.svg'),
            'title'=> __('notification.OfferCreated'),
            'desc'=>__('notification.OfferCreatedDesc'),
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
