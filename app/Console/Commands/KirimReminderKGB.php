<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Notifications\KenaikanGajiBerkalaReminder;

class KirimReminderKGB extends Command
{
   protected $signature = 'reminder:kgb {--dry-run : Hanya tampilkan tanpa mengirim}';
   protected $description = 'Kirim reminder kenaikan gaji berkala untuk window 30,7,1 hari sebelum TMT';

   protected array $windows = [30, 7, 1];

   public function handle(): int
   {
      if (! config('app.reminder_kgb_enabled', true)) {
         $this->info('Reminder KGB dinonaktifkan (config/app.reminder_kgb_enabled = false)');
         return self::SUCCESS;
      }

      $today = Carbon::today();
      $dry = $this->option('dry-run');
      $totalSent = 0;

      foreach ($this->windows as $w) {
         $targetDate = $today->copy()->addDays($w);
         $this->line("Memproses window {$w} hari (target TMT {$targetDate->toDateString()})...");

         $pegawais = Pegawai::query()
            ->whereDate('tanggal_kenaikan_gaji_berkala_berikutnya', $targetDate)
            ->with('user')
            ->get();

         foreach ($pegawais as $p) {
            $user = $p->user; // diasumsikan relation user()
            if (! $user) {
               continue;
            }

            // idempotensi: cek log
            $exists = DB::table('reminder_gaji_logs')
               ->where('pegawai_id', $p->id)
               ->whereDate('tmt', $targetDate)
               ->where('window', $w)
               ->exists();
            if ($exists) {
               continue;
            }

            if ($dry) {
               $this->line("[DRY] Akan kirim reminder ke Pegawai #{$p->id} ({$user->email}) window {$w}");
            } else {
               $user->notify(new KenaikanGajiBerkalaReminder(
                  pegawaiId: $p->id,
                  namaPegawai: $p->nama ?? $user->name,
                  nip: $p->nip ?? null,
                  tmt: $targetDate->copy(),
                  windowHari: $w
               ));

               DB::table('reminder_gaji_logs')->insert([
                  'pegawai_id' => $p->id,
                  'tmt' => $targetDate->toDateString(),
                  'window' => $w,
                  'sent_at' => now(),
                  'created_at' => now(),
                  'updated_at' => now(),
               ]);
               $totalSent++;
            }
         }
      }

      $this->info("Selesai. Total dikirim: {$totalSent}");
      return self::SUCCESS;
   }
}
