<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
class SendEmailsController extends Controller
{
    public function sendConfirmCode(Request $request) { 
        $title = $request->input('title');
        $content = $request->input('content');
        Mail::send('email.confirm', ['title' => $title, 'content' => $content], function ($message)
        {
            $message->from('admin@pdrrmo-bulacan.me', 'Dev Team');
            $message->to('einnar82@gmail.com');
        });
        return response()->json(['message' => 'Request completed']);
    }
}
