<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Messages;
use App\Events\ChatEvent;
use App\Events\NewMessageEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Notifications\NewMessageReceived;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function getMessages($format = null) {
        if ($format == 'desc') {
          return \App\Messages::with('user')
                              ->orderBy('created_at', 'desc')
                              ->get();
        }
        return \App\Messages::with('user')->get();
    }
  
    public function postMessages(Request $request) {
      $user = Auth::user();
      $message = $user->messages()->create([
        'message' => $request->input('message'),
        'messageDate' => Carbon::now('Asia/Shanghai')->toDateTimeString() 
      ]);
      broadcast(new ChatEvent($user, $message))->toOthers();
      // $user->notify(new NewMessageReceived($user));
      broadcast(new NewMessageEvent($message))->toOthers();
    }

    public function readMessageNotifications() {
      $user = Auth::user();
      $user->unreadNotifications->markAsRead();
    }
}

