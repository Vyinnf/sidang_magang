<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
   public function index(Request $request)
   {
      $q = ContactMessage::query();
      if ($request->get('filter') === 'unread') {
         $q->whereNull('read_at');
      }
      $messages = $q->latest()->paginate(10);
      $unreadCount = ContactMessage::whereNull('read_at')->count();
      return view('admin.contact_messages.index', compact('messages', 'unreadCount'));
   }

   public function show(ContactMessage $contactMessage)
   {
      if (!$contactMessage->read_at) {
         $contactMessage->forceFill(['read_at' => now()])->save();
      }
      return view('admin.contact_messages.show', compact('contactMessage'));
   }

   public function destroy(ContactMessage $contactMessage)
   {
      $contactMessage->delete();
      return redirect()->route('admin.contact-messages.index')->with('success', 'Pesan dihapus');
   }
}
