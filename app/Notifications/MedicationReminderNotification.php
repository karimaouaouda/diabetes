<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MedicationReminderNotification extends Notification
{
    // app/Notifications/MedicationReminderNotification.php
public function toFilament($notifiable): Notification
{
    return Notification::make()
        ->title('Rappel de médicament')
        ->icon('heroicon-o-bell')
        ->body("Il est l'heure de prendre votre {$this->medication->name} ({$this->medication->dosage})")
        ->actions([
            Action::make('marquer-comme-pris')
                ->button()
                ->color('success')
                ->dispatch('medicationTaken', $this->medication->id)
        ]);
}

public function toDatabase($notifiable)
{
    return [
        'type' => 'medication-reminder',
        'medication_id' => $this->medication->id,
        'message' => "Prise de {$this->medication->name} requise"
    ];
}
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

}
