<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ChatController extends Controller
{

    public function sendMessage(Request $request)
{
    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'message' => 'required|string',
    ]);

    $sender = $request->user();

    if (!$sender) {
        return response()->json([
            'message' => 'User not authenticated',
        ], 401);
    }

    $message = Chat::create([
        'sender_id' => $sender->id,
        'receiver_id' => $request->receiver_id,
        'message' => $request->message,
    ]);

    return response()->json([
        'message' => 'Message sent successfully',
        'data' => $message,
    ]);
}


public function getMessages($receiver_id)
{
    $user = Auth::user();


    if (!$user) {
        return response()->json([
            'message' => 'User not authenticated',
        ], 401);
    }

    $messages = Chat::where(function($query) use ($user, $receiver_id) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $receiver_id);
        })->orWhere(function($query) use ($user, $receiver_id) {
            $query->where('sender_id', $receiver_id)
                  ->where('receiver_id', $user->id);
        })->orderBy('created_at', 'ASC')->get();

    return response()->json($messages);
}

public function getChatList(Request $request)
{
    $user = $request->user(); 

    if (!$user) {
        return response()->json([
            'message' => 'User not authenticated',
        ], 401);
    }

    $user_id = $user->id;

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
                'first_name' => $otherUser->first_name,  
                'profile_image' => $otherUser->profile_image,
                'last_message' => $msg->message,
                'timestamp' => $msg->created_at->toDateTimeString(),
            ];
        });

    return response()->json($messages);
}




}
