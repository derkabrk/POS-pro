<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Party;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AcnooPartyController extends Controller
{
   use HasUploader;

    public function index()
    {
        $business_id = auth()->user()->business_id;
        $party_type = request('type');

        $query = Party::where('business_id', $business_id);

        if ($party_type === 'Customer') {
            $query->whereIn('type', ['Retailer', 'Dealer', 'Wholesaler']);
        } elseif ($party_type === 'Supplier') {
            $query->where('type', 'Supplier');
        }

        $parties = $query->latest()->paginate(20);

        return view('business::parties.index', compact('parties', 'party_type'));
    }

    public function acnooFilter(Request $request)
    {
        $search = $request->input('search');
        $party_type = $request->input('type');

        $parties = Party::where('business_id', auth()->user()->business_id)
                            ->when($search, function ($q) use ($search) {
                                $q->where(function ($q) use ($search) {
                                    $q->where('name', 'like', '%' . $search . '%')
                                        ->orWhere('email', 'like', '%' . $search . '%')
                                        ->orWhere('phone', 'like', '%' . $search . '%')
                                        ->orWhere('type', 'like', '%' . $search . '%')
                                        ->orWhere('address', 'like', '%' . $search . '%')
                                        ->orWhere('due', 'like', '%' . $search . '%');
                                });
                            });

        if ($party_type === 'Customer') {
            $parties->whereIn('type', ['Retailer', 'Dealer', 'Wholesaler']);
        } elseif ($party_type === 'Supplier') {
            $parties->where('type', 'Supplier');
        }

        $parties = $parties->latest()->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::parties.datas', compact('parties'))->render()
            ]);
        }

        return redirect(url()->previous());
    }

    public function create()
    {
        return view('business::parties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|max:20|unique:parties,phone',
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Retailer,Dealer,Wholesaler,Supplier',
            'email' => 'nullable|email|unique:parties,email',
            'image' => 'nullable|image|max:1024',
            'address' => 'nullable|string|max:255',
            'due' => 'nullable|numeric|min:0',
        ]);

        Party::create($request->except('image', 'due') + [
            'due' => $request->due ?? 0,
            'image' => $request->image ? $this->upload($request, 'image') : NULL,
            'business_id' => auth()->user()->business_id
        ]);

        $type = in_array($request->type, ['Retailer', 'Dealer', 'Wholesaler']) ? 'Customer' : ($request->type === 'Supplier' ? 'Supplier' : '');


        return response()->json([
            'message'   => __(ucfirst($type).' created successfully'),
            'redirect'  => route('business.parties.index', ['type' => $type])
        ]);

    }

    public function edit($id)
    {
        $party = Party::where('business_id', auth()->user()->business_id)->findOrFail($id);
        return view('business::parties.edit', compact('party'));
    }

    public function update(Request $request, $id)
    {
        $party = Party::findOrFail($id);

        $request->validate([
            'phone' => 'required|max:20|unique:parties,phone,' . $party->id,
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Retailer,Dealer,Wholesaler,Supplier',
            'email' => 'nullable|email|unique:parties,email,' . $party->id,
            'image' => 'nullable|image|max:1024',
            'address' => 'nullable|string|max:255',
            'due' => 'nullable|numeric|min:0',
        ]);

        $party->update($request->except('image', 'due') + [
            'due' => $request->due ?? 0,
            'image' => $request->image ? $this->upload($request, 'image', $party->image) : $party->image,
        ]);

        $type = in_array($party->type, ['Retailer', 'Dealer', 'Wholesaler']) ? 'Customer' : ($party->type === 'Supplier' ? 'Supplier' : '');

        return response()->json([
            'message'   => __(ucfirst($type).' updated successfully'),
            'redirect'  => route('business.parties.index', ['type' => $type])
        ]);
    }

    public function destroy($id)
    {
        $party = Party::findOrFail($id);
        if (file_exists($party->image)) {
            Storage::delete($party->image);
        }

        $party->delete();
        $type = in_array($party->type, ['Retailer', 'Dealer', 'Wholesaler']) ? 'Customer' : ($party->type === 'Supplier' ? 'Supplier' : '');

        return response()->json([
            'message' => ucfirst($party->type) . ' deleted successfully',
            'redirect' => route('business.parties.index', ['type' => $type]),
        ]);
    }


    public function deleteAll(Request $request)
    {
        $parties = Party::whereIn('id', $request->ids)->get();
        $partyType = null;

        foreach ($parties as $party) {
            if (file_exists($party->image)) {
                Storage::delete($party->image);
            }

            // first party's type
            if ($partyType === null) {
                $partyType = in_array($party->type, ['Retailer', 'Dealer', 'Wholesaler']) ? 'Customer' : ($party->type === 'Supplier' ? 'Supplier' : '');
            }
        }

        Party::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message'   => __('Selected parties deleted successfully'),
            'redirect'  => route('business.parties.index', ['type' => $partyType])
        ]);
    }
}
