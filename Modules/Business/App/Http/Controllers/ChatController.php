<?php

namespace Modules\Business\Http\Controllers;

use App\Events\ChatMessageSent;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

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
                $user->latest_message = $latestMessage;
                return $user;
            });
        return view('business::chat.index', compact('users'));
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

    public function searchUsers(Request $request)
    {
        $authId = Auth::id();
        $q = $request->input('q', '');
        $users = User::where('id', '!=', $authId)
            ->where(function($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                      ->orWhere('email', 'like', "%$q%");
            })
            ->get()
            ->map(function($user) use ($authId) {
                $latestMessage = Chat::where(function($q) use ($authId, $user) {
                    $q->where('sender_id', $authId)->where('receiver_id', $user->id);
                })->orWhere(function($q) use ($authId, $user) {
                    $q->where('sender_id', $user->id)->where('receiver_id', $authId);
                })->latest('created_at')->first();
                $user->latest_message = $latestMessage;
                $user->is_online = $user->is_online ?? false;
                if ($latestMessage) {
                    $user->latest_message->created_at_human = $latestMessage->created_at ? $latestMessage->created_at->diffForHumans() : '';
                }
                return $user;
            });
        return response()->json($users->values());
    }
}
