<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class KenaikanGajiBerkalaReminder extends Notification implements ShouldQueue
{
   use Queueable;

   public function __construct(
      public int $pegawaiId,
      public string $namaPegawai,
      public ?string $nip,
      public Carbon $tmt,
      public int $windowHari
   ) {}

   public function via(object $notifiable): array
   {
      return ['database', 'mail'];
   }

   public function toMail(object $notifiable): MailMessage
   {
      $subject = "Reminder Kenaikan Gaji Berkala ({$this->windowHari} hari lagi)";
      return (new MailMessage)
         ->subject($subject)
         ->view('emails.reminder_kgb', [
            'nama' => $this->namaPegawai,
            'nip' => $this->nip,
            'tmt' => $this->tmt->toDateString(),
            'window_hari' => $this->windowHari,
         ]);
   }

   public function toArray(object $notifiable): array
   {
      return [
         'pegawai_id' => $this->pegawaiId,
         'nama' => $this->namaPegawai,
         'nip' => $this->nip,
         'tmt' => $this->tmt->toDateString(),
         'window_hari' => $this->windowHari,
         // label legacy (dipakai oleh versi awal frontend)
         'label' => "Reminder KGB {$this->windowHari} hari sebelum TMT",
         // field baru agar frontend bisa konsisten
         'title' => "Reminder KGB {$this->windowHari} hari lagi",
         'message' => sprintf(
            'TMT %s untuk %s%s',
            $this->tmt->toDateString(),
            $this->namaPegawai,
            $this->nip ? ' (NIP: ' . $this->nip . ')' : ''
         ),
      ];
   }
}
