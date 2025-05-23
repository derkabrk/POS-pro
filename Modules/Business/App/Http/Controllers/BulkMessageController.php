<?php

namespace Modules\Business\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class BulkMessageController extends Controller
{
    public function index()
    {
        return view('business::bulk-message.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'type' => 'required|in:email,sms,whatsapp,viber',
            'recipients' => 'required|string',
            'message' => 'required|string',
        ]);
        $type = $request->type;
        $recipients = array_filter(array_map('trim', explode(',', $request->recipients)));
        $message = $request->message;
        $results = [];
        // Fetch users by email or phone
        $users = \App\Models\User::where(function($q) use ($recipients) {
            $q->whereIn('email', $recipients)->orWhereIn('phone', $recipients);
        })->get();
        foreach ($recipients as $recipient) {
            $user = $users->first(function($u) use ($recipient) {
                return $u->email === $recipient || $u->phone === $recipient;
            });
            $display = $user ? ($user->name . ' (' . ($user->email ?: $user->phone) . ')') : $recipient;
            switch ($type) {
                case 'email':
                    if ($user && $user->email) {
                        try {
                            Mail::raw($message, function ($mail) use ($user) {
                                $mail->to($user->email)->subject('Bulk Message');
                            });
                            $results[] = ['recipient' => $display, 'status' => 'sent'];
                        } catch (\Exception $e) {
                            $results[] = ['recipient' => $display, 'status' => 'failed', 'error' => $e->getMessage()];
                        }
                    } else {
                        $results[] = ['recipient' => $display, 'status' => 'skipped (no email)'];
                    }
                    break;
                case 'sms':
                    if ($user && $user->phone) {
                        Log::info("SMS sent to {$user->phone}: $message");
                        $results[] = ['recipient' => $display, 'status' => 'sent (simulated)'];
                    } else {
                        $results[] = ['recipient' => $display, 'status' => 'skipped (no phone)'];
                    }
                    break;
                case 'whatsapp':
                    if ($user && $user->phone) {
                        Log::info("WhatsApp sent to {$user->phone}: $message");
                        $results[] = ['recipient' => $display, 'status' => 'sent (simulated)'];
                    } else {
                        $results[] = ['recipient' => $display, 'status' => 'skipped (no phone)'];
                    }
                    break;
                case 'viber':
                    if ($user && $user->phone) {
                        Log::info("Viber sent to {$user->phone}: $message");
                        $results[] = ['recipient' => $display, 'status' => 'sent (simulated)'];
                    } else {
                        $results[] = ['recipient' => $display, 'status' => 'skipped (no phone)'];
                    }
                    break;
            }
        }
        return back()->with('results', $results);
    }
}
