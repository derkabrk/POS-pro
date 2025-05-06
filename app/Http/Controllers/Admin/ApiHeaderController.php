<?php
namespace App\Http\Controllers\Admin;
use App\Models\DynamicApiHeader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiHeaderController extends Controller
{
    /**
     * Display a listing of the API headers.
     */



    public function index()
    {
        $apiHeaders = DynamicApiHeader::latest()->paginate(10);
        return view('admin.dynamicApiHeader.index', compact('apiHeaders')); // Direct path
    }

    public function create()
    {
        return view('admin.dynamicApiHeader.create'); // Direct path
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:dynamic_api_headers,name',
            'api_key' => 'required|string|max:255',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
        ]);

        DynamicApiHeader::create($request->all());

        return response()->json([
            'message' => 'API Header created successfully.',
            'redirect' => route('admin.dynamicApiHeader.index'),
        ]);
    }

    public function edit(DynamicApiHeader $dynamicApiHeader)
    {
        return view('admin.dynamicApiHeader.edit', compact('dynamicApiHeader')); // Use direct path
    }

    public function update(Request $request, DynamicApiHeader $dynamicApiHeader)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:dynamic_api_headers,name,' . $dynamicApiHeader->id,
            'api_key' => 'required|string|max:255',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
        ]);

        $dynamicApiHeader->update($request->all());

        return redirect()->route('admin.dynamicApiHeader.index')->with('success', 'API Header updated successfully.');
    }

    public function destroy(DynamicApiHeader $dynamicApiHeader)
    {
        $dynamicApiHeader->delete();

        return redirect()->route('admin.dynamicApiHeader.index')->with('success', 'API Header deleted successfully.');
    }
}