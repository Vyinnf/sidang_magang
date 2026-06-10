<?php

namespace App\Services;

use Dompdf\Dompdf;
use Illuminate\Http\File as IlluminateFile;
use Illuminate\Http\UploadedFile;
use Symfony\Component\Process\Process;

class AttachmentPdfConverterService
{
   private ?bool $wordConversionAvailable = null;

   /**
    * Konversi file pendukung ke PDF sebelum disimpan.
    *
    * @return array{file: UploadedFile|IlluminateFile, display_name: string, cleanup_paths: array<int, string>}
    */
   public function convertToPdf(UploadedFile $file): array
   {
      $extension = strtolower($file->getClientOriginalExtension());
      $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

      if ($extension === 'pdf') {
         return [
            'file' => $file,
            'display_name' => $baseName . '.pdf',
            'cleanup_paths' => [],
         ];
      }

      if (in_array($extension, ['jpg', 'jpeg', 'png'], true)) {
         $pdfPath = $this->convertImageToPdf($file);

         return [
            'file' => new IlluminateFile($pdfPath),
            'display_name' => $baseName . '.pdf',
            'cleanup_paths' => [$pdfPath],
         ];
      }

      if (in_array($extension, ['doc', 'docx'], true)) {
         $conversion = $this->convertWordToPdf($file);

         return [
            'file' => new IlluminateFile($conversion['pdf_path']),
            'display_name' => $baseName . '.pdf',
            'cleanup_paths' => [$conversion['source_path'], $conversion['pdf_path']],
         ];
      }

      throw new \RuntimeException('Format file tidak didukung untuk konversi PDF.');
   }

   private function convertImageToPdf(UploadedFile $file): string
   {
      $tempDir = $this->ensureTempDir();
      $pdfPath = $tempDir . DIRECTORY_SEPARATOR . uniqid('pendukung_', true) . '.pdf';

      $mimeType = $file->getMimeType() ?: 'image/jpeg';
      $base64Image = base64_encode(file_get_contents($file->getRealPath()));

      $html = '<html><body style="margin:0;padding:0;display:flex;align-items:center;justify-content:center;">'
         . '<img src="data:' . $mimeType . ';base64,' . $base64Image . '" style="max-width:100%;max-height:100%;" />'
         . '</body></html>';

      $dompdf = new Dompdf();
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4');
      $dompdf->render();

      file_put_contents($pdfPath, $dompdf->output());

      return $pdfPath;
   }

   /**
    * @return array{source_path: string, pdf_path: string}
    */
   private function convertWordToPdf(UploadedFile $file): array
   {
      if (!$this->isWordConversionAvailable()) {
         throw new \RuntimeException('Konversi DOC/DOCX ke PDF tidak tersedia. Pastikan LibreOffice terpasang di server.');
      }

      $tempDir = $this->ensureTempDir();
      $uniqueName = uniqid('pendukung_', true);
      $sourcePath = $tempDir . DIRECTORY_SEPARATOR . $uniqueName . '.' . strtolower($file->getClientOriginalExtension());
      $pdfPath = $tempDir . DIRECTORY_SEPARATOR . $uniqueName . '.pdf';

      copy($file->getRealPath(), $sourcePath);

      foreach ($this->getSofficeExecutables() as $executable) {
         try {
            $process = new Process([
               $executable,
               '--headless',
               '--convert-to',
               'pdf',
               '--outdir',
               $tempDir,
               $sourcePath,
            ]);

            $process->setTimeout(120);
            $process->run();

            if ($process->isSuccessful() && file_exists($pdfPath)) {
               return [
                  'source_path' => $sourcePath,
                  'pdf_path' => $pdfPath,
               ];
            }
         } catch (\Throwable $e) {
            continue;
         }
      }

      if (file_exists($sourcePath)) {
         @unlink($sourcePath);
      }

      throw new \RuntimeException('Konversi DOC/DOCX ke PDF gagal. Pastikan LibreOffice terpasang di server.');
   }

   public function isWordConversionAvailable(): bool
   {
      if ($this->wordConversionAvailable !== null) {
         return $this->wordConversionAvailable;
      }

      foreach ($this->getSofficeExecutables() as $executable) {
         try {
            $process = new Process([$executable, '--version']);
            $process->setTimeout(8);
            $process->run();

            if ($process->isSuccessful()) {
               $this->wordConversionAvailable = true;
               return true;
            }
         } catch (\Throwable $e) {
            continue;
         }
      }

      $this->wordConversionAvailable = false;
      return false;
   }

   public function getWordConversionHealthMessage(): ?string
   {
      if ($this->isWordConversionAvailable()) {
         return null;
      }

      return 'Mesin konversi DOC/DOCX ke PDF (LibreOffice) belum terdeteksi. Upload DOC/DOCX tidak bisa diproses sampai LibreOffice terpasang di server.';
   }

   /**
    * @return array<int, string>
    */
   private function getSofficeExecutables(): array
   {
      return [
         'soffice',
         'soffice.com',
         'C:\\Program Files\\LibreOffice\\program\\soffice.exe',
         'C:\\Program Files (x86)\\LibreOffice\\program\\soffice.exe',
      ];
   }

   private function ensureTempDir(): string
   {
      $tempDir = storage_path('app/temp-conversion');

      if (!is_dir($tempDir)) {
         mkdir($tempDir, 0755, true);
      }

      return $tempDir;
   }
}
