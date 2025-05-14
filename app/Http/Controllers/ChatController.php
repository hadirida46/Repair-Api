<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function sendMessage(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Chat::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message,
        ]);
    }

    public function getMessages($sender_id, $receiver_id)
    {
        $messages = Chat::where(function($query) use ($sender_id, $receiver_id) {
            $query->where('sender_id', $sender_id)
                  ->where('receiver_id', $receiver_id);
        })->orWhere(function($query) use ($sender_id, $receiver_id) {
            $query->where('sender_id', $receiver_id)
                  ->where('receiver_id', $sender_id);
        })->orderBy('created_at', 'ASC')->get();

        return response()->json($messages);
    }
    public function getChatList($user_id)
{
    $latestMessages = Chat::selectRaw('
            LEAST(sender_id, receiver_id) as user1,
            GREATEST(sender_id, receiver_id) as user2,
            MAX(id) as latest_id
        ')
        ->where(function($q) use ($user_id) {
            $q->where('sender_id', $user_id)
              ->orWhere('receiver_id', $user_id);
        })
        ->groupBy('user1', 'user2')
        ->pluck('latest_id');

    $messages = Chat::with(['sender' => function($query) {
                $query->select('id', 'first_name', 'profile_image');
            }, 
            'receiver' => function($query) {
                $query->select('id', 'first_name', 'profile_image');
            }])
        ->whereIn('id', $latestMessages)
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($msg) use ($user_id) {
            $otherUser = $msg->sender_id == $user_id ? $msg->receiver : $msg->sender;

            return [
                'user_id' => $otherUser->id,
                'first_name' => $otherUser->first_name,  // Change 'name' to 'first_name'
                'profile_image' => $otherUser->profile_image,
                'last_message' => $msg->message,
                'timestamp' => $msg->created_at->toDateTimeString(),
            ];
        });

    return response()->json($messages);
}




}
