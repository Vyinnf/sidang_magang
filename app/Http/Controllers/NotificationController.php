<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
   public function index(Request $request)
   {
      $user = $request->user();
      $limit = (int) $request->get('limit', 15); // default baru 15

      // Ambil hanya unread
      $notifications = $user->unreadNotifications()
         ->latest()
         ->limit($limit)
         ->get()
         ->map(function ($n) {
            return [
               'id' => $n->id,
               'type' => class_basename($n->type),
               'data' => $n->data,
               'read_at' => $n->read_at,
               'created_at' => $n->created_at->toDateTimeString(),
               'time_ago' => $n->created_at->diffForHumans(),
               'is_unread' => is_null($n->read_at),
            ];
         });

      return response()->json([
         'unread_count' => $user->unreadNotifications()->count(),
         'items' => $notifications,
      ]);
   }

   public function markAllRead(Request $request)
   {
      $user = $request->user();
      $user->unreadNotifications->markAsRead();
      return response()->json(['status' => 'ok']);
   }

   public function markRead(Request $request, string $id)
   {
      $user = $request->user();
      /** @var DatabaseNotification|null $notification */
      $notification = $user->notifications()->where('id', $id)->first();
      if (!$notification) {
         return response()->json(['message' => 'Not found'], 404);
      }
      if (is_null($notification->read_at)) {
         $notification->markAsRead();
      }
      return response()->json(['status' => 'ok']);
   }
}
