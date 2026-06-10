<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuideController extends Controller
{
   public function index(Request $request)
   {
      return view('pegawai.guide.index');
   }
}
