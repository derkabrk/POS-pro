<?php

namespace Modules\Business\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Modules\Business\App\Models\SentBulkMessage;

class BulkMessageController extends Controller
{
    public function index()
    {
        $messages = SentBulkMessage::orderByDesc('created_at')->paginate(15);
        return view('business::bulk-message.index', compact('messages'));
    }

    public function create()
    {
        return view('business::bulk-message.create');
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
        $subject = $request->input('email_subject') ?: 'Bulk Message';
        $emailBody = $request->input('email_body');
        $headerImageUrl = null;
        if ($request->hasFile('email_image')) {
            $file = $request->file('email_image');
            $path = $file->store('bulk-email-images', 'public');
            $headerImageUrl = asset('storage/' . $path);
        }
        $results = [];
        // Fetch users by email or phone, but only those who are customers of the current business
        $businessId = auth()->user()->business_id;
        $users = \App\Models\User::where('business_id', $businessId)
            ->where(function($q) use ($recipients) {
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
                            if ($emailBody) {
                                $finalBody = $emailBody;
                                if ($headerImageUrl) {
                                    $finalBody = '<div style="text-align:center;margin-bottom:20px;"><img src="' . $headerImageUrl . '" style="max-width:100%;height:auto;" alt="Header"></div>' . $finalBody;
                                }
                                Mail::send([], [], function ($mail) use ($user, $subject, $finalBody) {
                                    $mail->to($user->email)
                                         ->subject($subject)
                                         ->setBody($finalBody, 'text/html');
                                });
                            } else {
                                Mail::raw($message, function ($mail) use ($user, $subject) {
                                    $mail->to($user->email)->subject($subject);
                                });
                            }
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
                        try {
                            // Ensure phone is in E.164 format for Infobip
                            $phone = $user->phone;
                            if (strpos($phone, '+') !== 0) {
                                // Optionally, prepend your country code if missing
                                // $phone = '+1' . preg_replace('/\D/', '', $phone); // Example for US
                                // For production, use a library like giggsey/libphonenumber-for-php for robust formatting
                            }
                            $response = Http::withHeaders([
                                'Authorization' => 'App ' . config('services.infobip.api_key'),
                                'Content-Type' => 'application/json',
                                'Accept' => 'application/json',
                            ])->post(rtrim(config('services.infobip.base_url'),'/') . '/sms/2/text/advanced', [
                                'messages' => [[
                                    'from' => config('services.infobip.sender'),
                                    'destinations' => [['to' => $phone]],
                                    'text' => $message,
                                ]],
                            ]);
                            if ($response->successful()) {
                                $results[] = ['recipient' => $display, 'status' => 'sent'];
                            } else {
                                $results[] = ['recipient' => $display, 'status' => 'failed', 'error' => $response->body()];
                            }
                        } catch (\Exception $e) {
                            $results[] = ['recipient' => $display, 'status' => 'failed', 'error' => $e->getMessage()];
                        }
                    } else {
                        $results[] = ['recipient' => $display, 'status' => 'skipped (no phone)'];
                    }
                    break;
                case 'whatsapp':
                    if ($user && $user->phone) {
                        try {
                            $response = Http::withHeaders([
                                'Authorization' => 'App ' . config('services.infobip.api_key'),
                                'Content-Type' => 'application/json',
                                'Accept' => 'application/json',
                            ])->post(rtrim(config('services.infobip.base_url'),'/') . '/whatsapp/1/message/text', [
                                'from' => config('services.infobip.sender'),
                                'to' => $user->phone,
                                'content' => [ 'text' => $message ],
                            ]);
                            if ($response->successful()) {
                                $results[] = ['recipient' => $display, 'status' => 'sent'];
                            } else {
                                $results[] = ['recipient' => $display, 'status' => 'failed', 'error' => $response->body()];
                            }
                        } catch (\Exception $e) {
                            $results[] = ['recipient' => $display, 'status' => 'failed', 'error' => $e->getMessage()];
                        }
                    } else {
                        $results[] = ['recipient' => $display, 'status' => 'skipped (no phone)'];
                    }
                    break;
                case 'viber':
                    if ($user && $user->phone) {
                        try {
                            $response = Http::withHeaders([
                                'Authorization' => 'App ' . config('services.infobip.api_key'),
                                'Content-Type' => 'application/json',
                                'Accept' => 'application/json',
                            ])->post(rtrim(config('services.infobip.base_url'),'/') . '/omni/1/advanced', [
                                'messages' => [[
                                    'from' => config('services.infobip.sender'),
                                    'destinations' => [['to' => $user->phone]],
                                    'viber' => [
                                        'text' => $message,
                                    ],
                                ]],
                            ]);
                            if ($response->successful()) {
                                $results[] = ['recipient' => $display, 'status' => 'sent'];
                            } else {
                                $results[] = ['recipient' => $display, 'status' => 'failed', 'error' => $response->body()];
                            }
                        } catch (\Exception $e) {
                            $results[] = ['recipient' => $display, 'status' => 'failed', 'error' => $e->getMessage()];
                        }
                    } else {
                        $results[] = ['recipient' => $display, 'status' => 'skipped (no phone)'];
                    }
                    break;
            }
        }

        // Save sent message log
        SentBulkMessage::create([
            'business_id' => $businessId,
            'user_id' => auth()->id(),
            'type' => $type,
            'recipients' => implode(',', $recipients),
            'subject' => $subject,
            'content' => $type === 'email' && $emailBody ? $emailBody : $message,
            'header_image' => $headerImageUrl,
            'results' => $results,
        ]);

        return back()->with('results', $results);
    }

    public function list()
    {
        $businessId = auth()->user()->business_id;
        $messages = SentBulkMessage::where('business_id', $businessId)->latest()->paginate(20);
        return view('business::bulk-message.list', compact('messages'));
    }
}
