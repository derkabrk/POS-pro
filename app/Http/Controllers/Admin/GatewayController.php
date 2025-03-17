<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HasUploader;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Gateway;
use Illuminate\Http\Request;

class GatewayController extends Controller
{
    use HasUploader;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gateways = Gateway::all();
        $currencies = Currency::latest()->get();

        return view('admin.gateways.index', compact('gateways', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request, $id)
    {
        Gateway::findOrFail($id)->update($request->except('image') + [
            'image' => $request->hasFile('image') ? $this->upload($request, 'image') : NULL
        ]);

        return response()->json('Gateway updated successfully');
    }
}
