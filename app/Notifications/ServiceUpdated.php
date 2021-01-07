<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceUpdated extends Notification
{
    use Queueable;

    protected $service;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($service)
    {
        $this->service = $service;
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
        $url = url('/account/services/'.$this->project->id.'/edit');

        return (new MailMessage)
                    ->line(__('notification.ServiceUpdatedEmail'))
                    ->line(__('notification.ServiceUpdatedDescEmail'))
                    ->action(__('notification.click_here'), $url);
    }


    public function toDatabase($notifiable)
    {
        return [
            'image'=> url('/images/notifications/add.svg'),
            'title'=> __('notification.ServiceUpdated'),
            'desc'=>__('notification.ServiceUpdatedDesc'),
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
