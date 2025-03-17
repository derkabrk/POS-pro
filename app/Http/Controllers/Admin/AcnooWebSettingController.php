<?php

namespace App\Http\Controllers\Admin;

use App\Models\Option;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class AcnooWebSettingController extends Controller
{
    use HasUploader;

    public function index()
    {
        $page_data = get_option('manage-pages');
        return view('admin.website-setting.manage-pages', compact('page_data'));
    }

    public function update(Request $request, $key)
    {
        $option = Option::where('key', 'manage-pages')->first();
        Option::updateOrCreate(
            ['key' => 'manage-pages'],
            ['value' => [
                'headings' => $request->except('_token', '_method', 'contact_img','card_icons','compatible_image','firebase_image','contact_us_icon','footer_socials_icons','footer_scanner_image','footer_apple_app_image','footer_google_app_image','watch_image','about_image','evanto_logo'),

                'slider_image' => $request->slider_image ? $this->upload($request, 'slider_image') : $option->value['slider_image'] ?? null,
                'scanner_image' => $request->scanner_image ? $this->upload($request, 'scanner_image') : $option->value['scanner_image'] ?? null,
                'watch_image' => $request->watch_image ? $this->upload($request, 'watch_image') : $option->value['watch_image'] ?? null,
                'compatible_image' => $request->compatible_image ? $this->upload($request, 'compatible_image') : $option->value['compatible_image'] ?? null,
                'firebase_image' => $request->firebase_image ? $this->upload($request, 'firebase_image') : $option->value['firebase_image'] ?? null,
                'contact_us_icon' => $request->contact_us_icon ? $this->upload($request, 'contact_us_icon') : $option->value['contact_us_icon'] ?? null,
                'footer_scanner_image' => $request->footer_scanner_image ? $this->upload($request, 'footer_scanner_image') : $option->value['footer_scanner_image'] ?? null,
                'footer_apple_app_image' => $request->footer_apple_app_image ? $this->upload($request, 'footer_apple_app_image') : $option->value['footer_apple_app_image'] ?? null,
                'footer_google_app_image' => $request->footer_google_app_image ? $this->upload($request, 'footer_google_app_image') : $option->value['footer_google_app_image'] ?? null,
                'about_image' => $request->about_image ? $this->upload($request, 'about_image') : $option->value['about_image'] ?? null,
                'evanto_logo' => $request->evanto_logo ? $this->upload($request, 'evanto_logo') : $option->value['evanto_logo'] ?? null,


                'card_icons' => $request->card_icons ? $this->multipleUpload($request, 'card_icons') : $option->value['card_icons'] ?? null,
                'footer_socials_icons' => $request->footer_socials_icons ? $this->multipleUpload($request, 'footer_socials_icons') : $option->value['footer_socials_icons'] ?? null,

            ]
        ]);

        Cache::forget('manage-pages');
        return response()->json(__('Pages updated successfully.'));
    }
}
