<?php

namespace App\Notifications;

use App\Enums\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RoleChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Role $role) {}

    /** @return list<string> */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Tu rol en '.config('app.name').' cambió')
            ->greeting('Hola '.$notifiable->name)
            ->line('Tu rol ahora es: '.$this->role->label().'.')
            ->action('Ir al panel', route('dashboard'));
    }

    /** @return array<string, mixed> */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Cambio de rol',
            'message' => 'Tu rol ahora es '.$this->role->label().'.',
            'url' => route('dashboard'),
        ];
    }
}
