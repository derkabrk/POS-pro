<?php

namespace App\Http\Controllers\Api;

use App\Models\Party;
use App\Models\Business;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartyController extends Controller
{
    use HasUploader;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Party::where('business_id', auth()->user()->business_id)->latest()->get();

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|max:20|unique:parties,phone',
        ]);

        $data = Party::create($request->except('image') + [
                    'image' => $request->image ? $this->upload($request, 'image') : NULL,
                    'business_id' => auth()->user()->business_id
                ]);

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $data,
        ]);
    }

    public function show(Party $party)
    {
        if (env('MESSAGE_ENABLED')) {
            if ($party->due) {
                $business = Business::findOrFail($party->business_id);
                $response = sendMessage($party->phone, dueMessage($party, $business->companyName));

                if ($response->successful()) {
                    return response()->json([
                        'message' => __('Message has been send successfully.'),
                    ]);
                }

                return response()->json([
                    'message' => __('Something was wrong, Please contact with admin.'),
                ], 406);
            } else {
                return response()->json([
                    'message' => __('This party has no due balance.'),
                ], 406);
            }
        } else {
            return response()->json([
                'message' => __('Message has been disabled by admin.'),
            ], 406);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Party $party)
    {
        $request->validate([
            'phone' => 'required|max:20|unique:parties,phone,' . $party->id,
        ]);

        $party = $party->update($request->except('image') + [
                    'image' => $request->image ? $this->upload($request, 'image', $party->image) : $party->image,
                ]);

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $party,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Party $party)
    {
        $party->delete();
        return response()->json([
            'message' => __('Data deleted successfully.'),
        ]);
    }
}
