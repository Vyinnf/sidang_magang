<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
   public function store(Request $request)
   {
      $validated = $request->validate([
         'name' => ['required', 'string', 'max:120'],
         'email' => ['required', 'email', 'max:190'],
         'subject' => ['nullable', 'string', 'max:120'],
         'message' => ['required', 'string', 'min:10'],
      ]);

      ContactMessage::create($validated);

      // Gunakan redirect standar ke landing dengan anchor #contact
      return redirect()->to(route('landing') . '#contact')
         ->with('success', 'Pesan berhasil dikirim.');
   }
}
