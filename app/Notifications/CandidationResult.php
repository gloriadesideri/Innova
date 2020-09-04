<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CandidationResult extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($candidate, $result)
    {
        $this->candidate=$candidate;
        $this->result=$result;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        switch ($this->result){
            case 'accept':
                return (new MailMessage)
                    ->line('Congratulations you\'re now an admin of '.$this->candidate->channel->name)
                    ->action('Visit your dashboard', url('/admin/dashboard'))
                    ->line('Thanks for your time');
                break;
            case 'decline':
                return (new MailMessage)
                    ->line('We are sorry to decline your application for '.$this->candidate->channel->name)
                    ->action('hope you enjoy your time here', url('/'))
                    ->line('Thanks for your time');
                break;
        }

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
