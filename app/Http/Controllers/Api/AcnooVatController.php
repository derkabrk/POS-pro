<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Vat;
use Illuminate\Http\Request;

class AcnooVatController extends Controller
{
    public function index()
    {
        $vats = Vat::where('business_id', auth()->user()->business_id)
                    ->when(request('type') == 'single', function ($query) {
                        $query->whereNull('sub_vat');
                    })
                    ->when(request('type') == 'group', function ($query) {
                        $query->whereNotNull('sub_vat');
                    })
                    ->when(request('status'), function ($query) {
                        $query->where('status', request('status') == 'active' ? 1 : 0);
                    })
                    ->latest()
                    ->get();

        return response()->json([
            'message' => 'Data fetched successfully.',
            'data' => $vats,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vat_ids' => 'required_if:rate,null',
            'rate' => 'required_if:rate,null|numeric',
        ]);

        if ($request->rate && !$request->vat_ids) {

            $vat = Vat::create($request->all() + [
                'business_id' => auth()->user()->business_id,
            ]);

        } elseif (!$request->rate && $request->vat_ids) {

            $vats = Vat::whereIn('id', $request->vat_ids)->select('id', 'name', 'rate')->get();

            $tax_rate = 0;
            $sub_vats = [];

            foreach ($vats as $vat) {
                $sub_vats[] = [
                    'id' => $vat->id,
                    'name' => $vat->name,
                    'rate' => $vat->rate,
                ];
                $tax_rate += $vat->rate;
            }

            $vat = Vat::create([
                'rate' => $tax_rate,
                'sub_vat' => $sub_vats,
                'name' => $request->name,
                'business_id' => auth()->user()->business_id,
            ]);

        } else {
            return response()->json([
                'message' => 'Invalid data format.',
            ], 406);
        }

        return response()->json([
            'message' => 'Data created successfully.',
            'data' => $vat,
        ]);
    }

    public function update(Request $request, Vat $vat)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vat_ids' => 'required_if:rate,null',
            'rate' => 'required_if:rate,null|numeric',
        ]);

        if ($request->rate && !$request->vat_ids) {

             $vat->update($request->all());

            $vatGroupExist = Vat::where('sub_vat', 'LIKE', '%"id":' . $vat->id . '%')->get();
            foreach ($vatGroupExist as $group) {
                $subVats = collect($group->sub_vat)->map(function ($subVat) use ($vat) {
                    if ($subVat['id'] == $vat->id) {
                        $subVat['rate'] = $vat->rate;
                        $subVat['name'] = $vat->name;
                    }
                    return $subVat;
                });

                $group->update([
                    'rate' => $subVats->sum('rate'),
                    'sub_vat' => $subVats->toArray(),
                ]);
            }

        } elseif (!$request->rate && $request->vat_ids) {

            $vats = Vat::whereIn('id', $request->vat_ids)->select('id', 'name', 'rate')->get();

            $tax_rate = 0;
            $sub_vats = [];

            foreach ($vats as $single_tax) {
                $sub_vats[] = [
                    'id' => $single_tax->id,
                    'name' => $single_tax->name,
                    'rate' => $single_tax->rate,
                ];
                $tax_rate += $single_tax->rate;
            }

             $vat->update([
                'rate' => $tax_rate,
                'sub_vat' => $sub_vats,
                'name' => $request->name,
                'status' => $request->status ?? $vat->status,
            ]);

        } else {
            return response()->json([
                'message' => 'Invalid data format.',
            ], 406);
        }

        return response()->json([
            'message' => 'Data updated successfully.',
            'data' => $vat,
        ]);
    }


    public function destroy(Vat $vat)
    {
        // When sub_vat is null, check if the VAT exists in any other VAT's sub_vat
        if (is_null($vat->sub_vat) && Vat::where('sub_vat', 'LIKE', '%"id":' . $vat->id . '%')->exists()) {
            return response()->json([
                'message' => 'Cannot delete. This VAT is part of a VAT group.',
            ], 404);
        }

        $vat->delete();

        return response()->json([
            'message' => 'Data deleted successfully',
        ]);
    }

}
