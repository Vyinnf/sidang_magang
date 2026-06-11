<?php

namespace App\Notifications;

use App\Models\PermohonanSk;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PermohonanSkBaru extends Notification
{
    use Queueable;

    public function __construct(public PermohonanSk $permohonanSk) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $pegawai = $this->permohonanSk->pegawai;
        $nama    = $pegawai?->user?->name ?? 'Pegawai';
        $nip     = $pegawai?->nip ? ' (NIP: ' . $pegawai->nip . ')' : '';

        return [
            'title'   => 'Permohonan SK Baru',
            'message' => sprintf(
                '%s%s mengajukan Permohonan SK Kenaikan Gaji Berkala.',
                $nama,
                $nip
            ),
            'url'     => route('operator.permohonan-sk.show', $this->permohonanSk->id),
        ];
    }
}
