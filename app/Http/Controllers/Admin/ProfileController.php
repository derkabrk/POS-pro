<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HasUploader;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use HasUploader;

    public function index()
    {
        $user = User::where('id',Auth::user()->id)->first();
        return view('admin.profile.index',compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'image' => 'nullable|image',
        ]);
        $user = User::findOrFail($id);

        if( $request->password || $request->current_password){
            if(Hash::check($request->current_password,$user->password)){
                $request->validate([
                    'current_password' => 'required|string',
                    'password' => 'required|string|confirmed',
                ]);
            }
            else{
                return response()->json(__('Current Password does not match with old password'),404);
            }
        }

        $user->update($request->except('image', 'password') + [
                'image' => $request->image ? $this->upload($request, 'image', $user->image) : $user->image,
            ] + ($request->password ? ['password' => Hash::make($request->password)] : [])
        );

        return response()->json([
            'message'   => __('Profile updated successfully'),
            'redirect'  => route('admin.profiles.index')
        ]);
    }
}
