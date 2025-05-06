<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\DynamicApiHeader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiHeaderController extends Controller
{
    /**
     * Display a listing of the API headers.
     */

    public function __construct()
    {
        $this->middleware('dynamic-api-headers-create')->only('create', 'store');
        $this->middleware('dynamic-api-headers-read')->only('index');
        $this->middleware('dynamic-api-headers-update')->only('edit', 'update');
        $this->middleware('dynamic-api-headers-delete')->only('destroy');
    }

    public function index()
    {
        $apiHeaders = DynamicApiHeader::latest()->paginate(10);
        return view('admin::dynamicApiHeader.index', compact('apiHeaders'));
    }

    public function create()
    {
        return view('admin::dynamicApiHeader.create');
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

        return redirect()->route('admin.dynamicApiHeader.index')->with('success', 'API Header created successfully.');
    }

    public function edit(DynamicApiHeader $dynamicApiHeader)
    {
        return view('admin::dynamicApiHeader.edit', compact('dynamicApiHeader'));
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