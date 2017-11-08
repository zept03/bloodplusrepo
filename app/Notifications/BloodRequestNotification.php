<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BloodRequestNotification extends Notification
{
    use Queueable;

    public $bloodRequest;
    public $user;
    public $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($instance,$user,$message)
    {
        $this->user = $user;
        $this->instance = $instance;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
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

    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage([
    //         ]);
    // }

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
    public function toDatabase($notifiable)
    {
        return [
            'class' => $this->instance,
            'user' => $this->user,
            'message' => $this->message
        ];
    }

    public function toBroadcast($notifiable)
    {
        // dd($notifiable->id);
        return new BroadcastMessage([
            'data' => [
            'class' => $this->instance,
            'user' => $this->user,
            'message' => $this->message
            ]
        ]);
    }

}
