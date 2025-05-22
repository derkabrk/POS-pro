<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $authId = Auth::id();
        $users = User::where('id', '!=', $authId)
            ->get()
            ->map(function($user) use ($authId) {
                $latestMessage = \App\Models\Chat::where(function($q) use ($authId, $user) {
                    $q->where('sender_id', $authId)->where('receiver_id', $user->id);
                })->orWhere(function($q) use ($authId, $user) {
                    $q->where('sender_id', $user->id)->where('receiver_id', $authId);
                })->latest('created_at')->first();
                if ($latestMessage) {
                    $latestMessage->content = $latestMessage->message;
                }
                $user->latest_message = $latestMessage;
                return $user;
            });
        return view('chat.index', compact('users'));
    }

    public function fetchMessages($userId)
    {
        $messages = Chat::where(function($q) use ($userId) {
            $q->where('sender_id', Auth::id())
              ->where('receiver_id', $userId);
        })->orWhere(function($q) use ($userId) {
            $q->where('sender_id', $userId)
              ->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();

        // Add 'content' property for frontend compatibility
        $messages->transform(function($msg) {
            $msg->content = $msg->message;
            return $msg;
        });

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $chat = Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        broadcast(new ChatMessageSent($chat))->toOthers();

        return response()->json($chat);
    }

    // Add a global user search endpoint for chat (search only users table, not chats)
    public function searchUsers(Request $request)
    {
        $q = $request->input('q');
        $authId = Auth::id();
        $users = User::where('id', '!=', $authId)
            ->where(function($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                      ->orWhere('email', 'like', "%$q%") ;
            })
            ->get();
        // Attach latest message if exists, but do not filter by chat
        $users = $users->map(function($user) use ($authId) {
            $latestMessage = Chat::where(function($q) use ($authId, $user) {
                $q->where('sender_id', $authId)->where('receiver_id', $user->id);
            })->orWhere(function($q) use ($authId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $authId);
            })->latest('created_at')->first();
            if ($latestMessage) {
                $latestMessage->content = $latestMessage->message;
            }
            $user->latest_message = $latestMessage;
            return $user;
        });
        return response()->json($users->values());
    }
}
