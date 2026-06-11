<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PesanKontakBaru extends Notification
{
    use Queueable;

    public function __construct(public ContactMessage $contactMessage) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title'   => 'Pesan Baru dari Tamu',
            'message' => sprintf(
                '%s (%s) mengirim pesan: "%s"',
                $this->contactMessage->name,
                $this->contactMessage->email,
                \Str::limit($this->contactMessage->message, 80)
            ),
            'url'     => route('admin.contact-messages.show', $this->contactMessage->id),
        ];
    }
}
