<?php

namespace App\Notification;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BookingConfirmed extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Conferma prenotazione')
                    ->greeting('Ciao ' . $notifiable->name . ',')
                    ->line('La tua prenotazione è stata confermata.')
                    ->line('L\'orario della lezione è: ' . $notifiable->lesson_time)
                    ->line('Grazie per averci scelto!');
    }
}
