<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\File as IlluminateFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class FileStorageService
{
    public function upload($file, string $type, ?User $user = null): string
    {
        if (!($file instanceof UploadedFile) && !($file instanceof IlluminateFile)) {
            throw new \InvalidArgumentException('File harus berupa UploadedFile atau File');
        }
        $unitKerjaId = $user ? $user->unit_kerja_id : null;
        $userId = $user?->id;

        $folderMap = [
            'profile' => "{$unitKerjaId}/{$userId}/profile",
            'sk-gbk' => "{$unitKerjaId}/{$userId}/sk-gbk",
            'sk-pengangkatan' => "{$unitKerjaId}/{$userId}/sk-pengangkatan",
            'template-sk-gbk' => "{$unitKerjaId}/template-sk-gbk",
            'sk-kenaikan-pangkat' => "{$unitKerjaId}/{$userId}/sk-kenaikan-pangkat",
            'permohonan-sk-pendukung' => "{$unitKerjaId}/{$userId}/permohonan-sk-pendukung",
        ];

        if (!array_key_exists($type, $folderMap)) {
            throw new \InvalidArgumentException("Tipe folder tidak dikenali: {$type}");
        }

        $extension = $file instanceof UploadedFile ? $file->getClientOriginalExtension() : pathinfo($file->getPathname(), PATHINFO_EXTENSION);

        $path = $folderMap[$type];
        $filename = uniqid() . '.' . $extension;

        return Storage::disk('local')->putFileAs($path, $file, $filename);
    }

    public function download(string $path, ?string $downloadName = null)
    {
        $fullPath = storage_path('app/private/' . $path);

        if (!file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($fullPath, $downloadName);
    }

    public function access(string $path)
    {
        $fullPath = storage_path('app/private/' . $path);

        if (!file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan');
        }

        $mime = mime_content_type($fullPath);

        return Response::file($fullPath, [
            'Content-Type' => $mime,
        ]);
    }

    public function delete(string $path): bool
    {
        if (Storage::disk('local')->exists($path)) {
            return Storage::disk('local')->delete($path);
        }

        return false;
    }
}
