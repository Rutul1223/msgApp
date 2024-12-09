<?php

namespace App\Http\Controllers;

use App\Events\MessageSendEvent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function show($user_id)
    {
        $sender_id = Auth::id();
        $reciever_id = $user_id;

        // Fetch messages
        $messages = Message::where(function($query) use ($sender_id, $reciever_id) {
            $query->where('sender_id', $sender_id)
                  ->where('reciever_id', $reciever_id);
        })->orWhere(function($query) use ($sender_id, $reciever_id) {
            $query->where('sender_id', $reciever_id)
                  ->where('reciever_id', $sender_id);
        })
        ->with('sender:id,name', 'reciever:id,name')
        ->get();

        // Fetch user
        $user = User::find($user_id);

        return view('chat', [
            'user' => $user,
            'messages' => $messages
        ]);
    }
    public function sendMessage(Request $request)
{
    $request->validate([
        'message' => 'required|string|max:255',
        'reciever_id' => 'required|exists:users,id'
    ]);

    $sender_id = Auth::id();
    $reciever_id = $request->input('reciever_id');
    $messageContent = $request->input('message');

    $message = Message::create([
        'sender_id' => $sender_id,
        'reciever_id' => $reciever_id,
        'message' => $messageContent,
    ]);

    // Broadcast the message
    broadcast(new MessageSendEvent($message))->toOthers();

    return response()->json(['status' => 'Message sent successfully']);
}

}
