<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feature;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AcnooFeatureController extends Controller
{
    use HasUploader;

    public function index(Request $request)
    {
        $features = Feature::latest()->paginate(20);
        return view('admin.website-setting.features.index', compact('features'));
    }


    public function acnooFilter(Request $request)
    {
        $features = Feature::when(request('search'), function ($q) {
            $q->where(function ($q) {
                $q->where('title', 'like', '%' . request('search') . '%');
            });
        })
            ->latest()
            ->paginate($request->per_page ?? 20);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('admin.website-setting.features.datas', compact('features'))->render()
            ]);
        }

        return redirect(url()->previous());
    }

    public function create()
    {
        return view('admin.website-setting.features.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'title' => 'required',
            'bg_color' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        Feature::create($request->except('image') + [
            'image' => $request->image ? $this->upload($request, 'image') : NULL
        ]);

        return response()->json([
            'message' => __('Feature created successfully'),
            'redirect' => route('admin.features.index')
        ]);
    }

    public function edit(Feature $feature)
    {
        return view('admin.website-setting.features.edit', compact('feature'));
    }

    public function update(Request $request, Feature $feature)
    {
        $request->validate([
            'status' => 'required',
            'title' => 'required|string',
            'bg_color' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $feature->update($request->except('image') + [
            'image' => $request->image ? $this->upload($request, 'image', $feature->image) : $feature->image,
        ]);

        return response()->json([
            'message' => __('Feature updated successfully'),
            'redirect' => route('admin.features.index')
        ]);
    }

    public function destroy(Feature $feature)
    {
        if (file_exists($feature->image)) {
            Storage::delete($feature->image);
        }
        $feature->delete();

        return response()->json([
            'message'   => __('Feature deleted successfully'),
            'redirect'  => route('admin.features.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $feature = Feature::findOrFail($id);
        $feature->update(['status' => $request->status]);
        return response()->json(['message' => 'Feature ']);
    }


    public function deleteAll(Request $request)
    {
        $features = Feature::whereIn('id', $request->ids)->get();
        foreach ($features as $feature) {
            if (file_exists($feature->image)) {
                Storage::delete($feature->image);
            }
        }

        $features->each->delete();

        return response()->json([
            'message' => __('Selected Feature deleted successfully'),
            'redirect' => route('admin.features.index')
        ]);
    }
}
