<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use App\Models\PosAppInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AcnooInterfaceController extends Controller
{
    use HasUploader;

    public function index(Request $request)
    {
        $interfaces = PosAppInterface::latest()->paginate(20);
        return view('admin.website-setting.interfaces.index', compact('interfaces'));
    }

    public function acnooFilter(Request $request)
    {
        $interfaces = PosAppInterface::latest()->paginate($request->per_page ?? 20);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('admin.website-setting.interfaces.datas', compact('interfaces'))->render()
            ]);
        }

        return redirect(url()->previous());
    }

    public function create()
    {
        return view('admin.website-setting.interfaces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        PosAppInterface::create($request->except('image') + [
            'image' => $request->image ? $this->upload($request, 'image') : NULL
        ]);

        return response()->json([
            'message' => __('Interfaces created successfully'),
            'redirect' => route('admin.interfaces.index')
        ]);
    }

    public function edit($id)
    {
        $interface = PosAppInterface::findOrFail($id);
        return view('admin.website-setting.interfaces.edit', compact('interface'));
    }

    public function update(Request $request,  $id)
    {
        $interface = PosAppInterface::findOrFail($id);
        $request->validate([
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $interface->update($request->except('image') + [
            'image' => $request->image ? $this->upload($request, 'image', $interface->image) : $interface->image,
        ]);

        return response()->json([
            'message' => __('Interface updated successfully'),
            'redirect' => route('admin.interfaces.index')
        ]);
    }

    public function destroy($id)
    {
        $posAppInterface = PosAppInterface::findOrFail($id);
        if (file_exists($posAppInterface->image)) {
            Storage::delete($posAppInterface->image);
        }
        $posAppInterface->delete();

        return response()->json([
            'message'   => __('Interface deleted successfully'),
            'redirect'  => route('admin.interfaces.index')
        ]);
    }

    public function status(Request $request,$id)
    {
        $posAppInterface = PosAppInterface::findOrFail($id);
        $posAppInterface->update(['status' => $request->status]);
        return response()->json(['message' => 'Interface ']);
    }

    public function deleteAll(Request $request)
    {
        $posAppInterfaces = PosAppInterface::whereIn('id', $request->ids)->get();
        foreach ($posAppInterfaces as $posAppInterface) {
            if (file_exists($posAppInterface->image)) {
                Storage::delete($posAppInterface->image);
            }
        }

        $posAppInterfaces->each->delete();

        return response()->json([
            'message' => __('Selected Interface deleted successfully'),
            'redirect' => route('admin.interfaces.index')
        ]);
    }
}
