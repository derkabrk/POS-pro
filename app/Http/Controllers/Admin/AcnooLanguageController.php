<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AcnooLanguageController extends Controller
{
    use HasUploader;
    public function index(Request $request)
    {
        $languages = Language::when($request->has('search'), function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            });
        })
            ->latest();

        if ($request->ajax()) {
            $languages = $languages->get();

            return response()->json([
                'data' => view('admin.website-setting.languages.datas', compact('languages'))->render()
            ]);
        }

        $languages = $languages->paginate(20);
        return view('admin.website-setting.languages.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.website-setting.languages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'name' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        Language::create($request->except('icon') + [
            'icon' => $request->icon ? $this->upload($request, 'icon') : NULL
        ]);

        return response()->json([
            'message' => __('Laguage created successfully'),
            'redirect' => route('admin.languages.index')
        ]);
    }

    public function edit(Language $language)
    {
        return view('admin.website-setting.languages.edit', compact('language'));
    }

    public function update(Request $request, Language $language)
    {
        $request->validate([
            'status' => 'required',
            'name' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $language->update($request->except('icon') + [
            'icon' => $request->icon ? $this->upload($request, 'icon', $language->icon) : $language->icon,
        ]);

        return response()->json([
            'message' => __('Language updated successfully'),
            'redirect' => route('admin.languages.index')
        ]);
    }

    public function destroy(Language $language)
    {
        if (file_exists($language->icon)) {
            Storage::delete($language->icon);
        }
        $language->delete();

        return response()->json([
            'message'   => __('Language deleted successfully'),
            'redirect'  => route('admin.languages.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $language = Language::findOrFail($id);
        $language->update(['status' => $request->status]);
        return response()->json(['message' => 'Language ']);
    }


    public function deleteAll(Request $request)
    {
        $languages = Language::whereIn('id', $request->ids)->get();
        foreach ($languages as $language) {
            if (file_exists($language->icon)) {
                Storage::delete($language->icon);
            }
        }

        $languages->each->delete();

        return response()->json([
            'message' => __('Selected Language deleted successfully'),
            'redirect' => route('admin.languages.index')
        ]);
    }
}
