<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HasUploader;
use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    use HasUploader;

    public function __construct()
    {
        $this->middleware('permission:settings-read')->only('index');
        $this->middleware('permission:settings-update')->only('update');
    }

    public function index()
    {
        $general = Option::where('key','general')->first();
        return view('admin.settings.general',compact('general'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'logo' => 'nullable|image',
            'favicon' => 'nullable|image',
            'common_header_logo' => 'nullable|image',
            'footer_logo' => 'nullable|image',
            'admin_logo' => 'nullable|image',
            'login_page_logo' => 'nullable|image',
            'login_page_image' => 'nullable|image',
            'app_link' => 'nullable|url',
        ]);

        $general = Option::findOrFail($id);
        Cache::forget($general->key);
        $general->update([
            'value' => $request->except('_token','_method','logo','favicon','common_header_logo','footer_logo','admin_logo', 'login_page_logo', 'login_page_image') + [
                    'logo' => $request->logo ? $this->upload($request, 'logo', $general->logo) : $general->value['logo'],
                    'favicon' => $request->favicon ? $this->upload($request, 'favicon', $general->favicon) : $general->value['favicon'],
                    'common_header_logo' => $request->common_header_logo ? $this->upload($request, 'common_header_logo', $general->common_header_logo) : $general->value['common_header_logo'],
                    'footer_logo' => $request->footer_logo ? $this->upload($request, 'footer_logo', $general->footer_logo) : $general->value['footer_logo'],
                    'admin_logo' => $request->admin_logo ? $this->upload($request, 'admin_logo', $general->admin_logo) : $general->value['admin_logo'],
                    'login_page_logo' => $request->login_page_logo ? $this->upload($request, 'login_page_logo', $general->login_page_logo) : $general->value['login_page_logo'],
                    'login_page_image' => $request->login_page_image ? $this->upload($request, 'login_page_image', $general->login_page_image) : $general->value['login_page_image'],
                ]
        ]);

        return response()->json([
            'message'   => __('General Setting updated successfully'),
            'redirect'  => route('admin.settings.index')
        ]);
    }
}
