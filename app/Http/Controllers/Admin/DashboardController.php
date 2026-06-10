<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Golongan;
use App\Models\Pegawai;
use App\Models\UnitKerja;
use App\Models\User;
use App\Models\ContactMessage;
use App\Services\AttachmentPdfConverterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(private AttachmentPdfConverterService $attachmentPdfConverterService) {}

    public function index()
    {
        $totalUsers = User::count();
        $totalPegawai = Pegawai::count();
        $totalGolongan = Golongan::count();
        $totalUnitKerja = UnitKerja::count();
        $user = Auth::user();
        $unreadContactMessages = ContactMessage::whereNull('read_at')->count();
        $wordConversionHealthMessage = $this->attachmentPdfConverterService->getWordConversionHealthMessage();

        return view('admin.dashboard', compact(
            'user',
            'totalUsers',
            'totalPegawai',
            'totalGolongan',
            'totalUnitKerja',
            'unreadContactMessages',
            'wordConversionHealthMessage'
        ));
    }
}
