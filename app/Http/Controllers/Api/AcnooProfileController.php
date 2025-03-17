<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AcnooProfileController extends Controller
{
    use HasUploader;

    public function index()
    {
        $user = User::with('business')->findOrFail(auth()->id());
        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $user
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|max:250',
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->id())],
            'image' => 'nullable|image|mimes:jpeg,png,gif|dimensions:max_width=2000,max_height=2000|max:1048',
        ]);

        $user = User::findOrFail(auth()->id());

        $user->update($request->except('image') + [
            'image' => $request->image ? $this->upload($request, 'image', $user->image) : $user->image,
        ]);

        $user = User::findOrFail(auth()->id());

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'image' => $user->image,
        ];

        return response()->json([
            'message' => __('Profile updated successfully.'),
            'data' => $data,
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|string|min:6',
            'password_confirmation' => 'required',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'error' => __('Current password does not match with old password.')
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message'   => __('Password changed successfully.'),
        ]);
    }
}
