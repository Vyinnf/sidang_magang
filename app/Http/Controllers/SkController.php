<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RiwayatGbk;
use Illuminate\Http\Request;

class SkController extends Controller
{
     public function download($path)
    {
        dd($path);

        $path = storage_path('app/private/' .$path);

        // if (!file_exists($path)) {
        //     abort(404, 'File SK tidak ditemukan.');
        // }

        return response()->download($path);
    }
}
