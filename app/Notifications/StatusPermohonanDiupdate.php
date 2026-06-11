<?php

namespace App\Notifications;

use App\Models\PermohonanSk;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StatusPermohonanDiupdate extends Notification
{
    use Queueable;

    public function __construct(public PermohonanSk $permohonanSk) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $statusLabel = match ($this->permohonanSk->status) {
            'diproses'  => 'Sedang Diproses',
            'disetujui' => 'Disetujui',
            'ditolak'   => 'Ditolak',
            default     => ucfirst($this->permohonanSk->status),
        };

        $catatan = $this->permohonanSk->catatan_operator
            ? ' Catatan operator: ' . \Str::limit($this->permohonanSk->catatan_operator, 80)
            : '';

        return [
            'title'   => 'Status Permohonan SK Diperbarui',
            'message' => sprintf(
                'Permohonan SK Anda berstatus: %s.%s',
                $statusLabel,
                $catatan
            ),
            'url'     => route('pegawai.permohonan-sk.show', $this->permohonanSk->id),
        ];
    }
}
