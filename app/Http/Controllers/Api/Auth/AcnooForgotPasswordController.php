<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Mail\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class AcnooForgotPasswordController extends Controller
{
    public function sendResetCode(Request $request) : JsonResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $expire = now()->addHour();
        $code = random_int(100000,999999);
        $user = User::where('email',$request->email)->first();
        $user->update(['remember_token' => $code, 'email_verified_at' => $expire]);

        $data = [
            'code' => $code
        ];

        try {
            if (env('QUEUE_MAIL')) {
                Mail::to($request->email)->queue(new PasswordReset($data));
            } else {
                Mail::to($request->email)->send(new PasswordReset($data));
            }
            return response()->json([
                'message' => 'Password reset code has been sent to your email.',
            ]);

        } catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }
    }

    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'code' => 'required|integer',
            'email' => 'required|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->remember_token == $request->code) {
            if ($user->email_verified_at > now()) {
                return response()->json([
                    'message' => __('The code has been verified.')
                ]);
            } else {
                return response()->json([
                    'error' => __('The verification code has expired.')
                ], 400);
            }
        } else {
            return response()->json([
                'error' => __('Invalid Code.')
            ], 404);
        }
    }

    public function resetPassword(Request $request) : JsonResponse
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => ['required', 'min:4'],
        ]);

        $user = User::where('email', $request->email)->first();

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Your password has been changed!',
        ]);
    }
}
