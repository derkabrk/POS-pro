<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\DynamicApiHeader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DynamicApiHeaderController extends Controller
{
    /**
     * Display a listing of the API headers.
     */
    public function index()
    {
        $apiHeaders = DynamicApiHeader::latest()->paginate(10);
        return view('admin::dynamicApiHeader.index', compact('apiHeaders'));
    }

    /**
     * Show the form for creating a new API header.
     */
    public function create()
    {
        return view('admin::dynamicApiHeader.create');
    }

    /**
     * Store a newly created API header in storage.
     */
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

    /**
     * Show the form for editing the specified API header.
     */
    public function edit(DynamicApiHeader $dynamicApiHeader)
    {
        return view('admin::dynamicApiHeader.edit', compact('dynamicApiHeader'));
    }

    /**
     * Update the specified API header in storage.
     */
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

    /**
     * Remove the specified API header from storage.
     */
    public function destroy(DynamicApiHeader $dynamicApiHeader)
    {
        $dynamicApiHeader->delete();

        return redirect()->route('admin.dynamicApiHeader.index')->with('success', 'API Header deleted successfully.');
    }
}