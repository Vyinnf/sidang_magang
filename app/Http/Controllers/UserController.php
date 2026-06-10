<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        switch (Auth::user()->role) {
            case 'admin':
                $dataUser = User::all();
                return view('admin.manajemen-pengguna.index', compact('dataUser'));
                break;

            case 'operator':
                $dataUser = User::where('unit_kerja_id', Auth::user()->unit_kerja_id)->get();
                return view('operator.manajemen-pegawai.index', compact('dataUser'));
                break;

            default:
                abort(500);
        }
    }
}
