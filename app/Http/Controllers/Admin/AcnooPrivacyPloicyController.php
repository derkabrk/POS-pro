<?php

namespace App\Http\Controllers\Admin;

use App\Models\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class AcnooPrivacyPloicyController extends Controller
{
    public function index()
    {
        $privacy_policy = Option::where('key', 'privacy-policy')->first();
        return view('admin.settings.privacy-policy.index', compact('privacy_policy'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'privacy_title' => 'required|string',
            'description_one' => 'required|string',
            'description_two' => 'required|string',
        ]);

        Option::updateOrCreate(
            ['key' => 'privacy-policy'],
            ['value' => [
                'privacy_title' => $request->privacy_title,
                'description_one' => $request->description_one,
                'description_two' => $request->description_two
            ]]
        );

        Cache::forget('privacy-policy');
        return response()->json(__('Privacy And Policy updated successfully.'));
    }
}
