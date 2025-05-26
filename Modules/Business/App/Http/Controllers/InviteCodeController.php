<?php

namespace Modules\Business\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Business\App\Models\InviteCode;

class InviteCodeController extends Controller
{
    public function index()
    {
        $codes = InviteCode::latest()->paginate(20);
        return view('business::invite-codes.index', compact('codes'));
    }

    public function create()
    {
        return view('business::invite-codes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'expires_at' => 'nullable|date|after:now',
        ]);
        $code = InviteCode::generateUniqueCode();
        InviteCode::create([
            'code' => $code,
            'expires_at' => $request->expires_at,
        ]);
        return redirect()->route('business.invite-codes.index')->with('success', 'Invite code created!');
    }

    public function redeem(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:invite_codes,code',
        ]);
        $invite = InviteCode::where('code', $request->code)->first();
        if ($invite->used) {
            return back()->withErrors(['code' => 'This invite code has already been used.']);
        }
        if ($invite->expires_at && $invite->expires_at->isPast()) {
            return back()->withErrors(['code' => 'This invite code has expired.']);
        }
        $invite->update([
            'used' => true,
            'used_by' => Auth::id(),
        ]);
        return redirect()->route('dashboard')->with('success', 'Invite code redeemed!');
    }
}
