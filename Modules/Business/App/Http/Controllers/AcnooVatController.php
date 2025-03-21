<?php

namespace Modules\Business\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcnooVatController extends Controller
{

    public function index(Request $request)
    {
        $vats = Vat::where('business_id', auth()->user()->business_id)->orderBy('status', 'desc')->whereNull('sub_vat')->latest()->paginate(10);
        $vat_groups = Vat::where('business_id', auth()->user()->business_id)->orderBy('status', 'desc')->whereNotNull('sub_vat')->latest()->paginate(10);
        return view('business::vats.index', compact('vats', 'vat_groups'));
    }

    public function acnooFilter(Request $request)
    {
        $vats = Vat::where('business_id', auth()->user()->business_id)->whereNull('sub_vat')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $search = $request->search;
                    $q->where('name', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::vats.datas', compact('vats'))->render()
            ]);
        }
        return redirect(url()->previous());

    }

    public function VatGroupFilter(Request $request)
    {
        $vat_groups = Vat::where('business_id', auth()->user()->business_id)->whereNotNull('sub_vat')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $search = $request->search;
                    $q->where('name', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::vat-groups.datas', compact('vat_groups'))->render()
            ]);
        }
        return redirect(url()->previous());

    }


    // Vat Group Create
    public function create()
    {
        $vats = Vat::where('business_id', auth()->user()->business_id)->where('status','1')->whereNull('sub_vat')->latest()->get();
        return view('business::vat-groups.create',compact('vats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vat_ids' => 'required_if:rate,null',
            'rate' => 'required_if:rate,null|numeric',
        ]);

        // single vat
        if ($request->rate && !$request->vat_ids) {
            Vat::create($request->all() + [
                'business_id' => auth()->user()->business_id,
            ]);

        }
        // group vat
        elseif (!$request->rate && $request->vat_ids) {

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

            Vat::create([
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
            'message' => 'Vat created successfully',
            'redirect' => route('business.vats.index'),
        ]);
    }

    // Vat Group Edit
    public function edit($id)
    {
        $vat = Vat::where('business_id', auth()->user()->business_id)->findOrFail($id);
        $vats = Vat::where('business_id', auth()->user()->business_id)->where('status','1')->whereNull('sub_vat')->latest()->paginate(10);
        return view('business::vat-groups.edit',compact('vat', 'vats'));
    }


    public function update(Request $request, Vat $vat)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vat_ids' => 'required_if:rate,null',
            'rate' => 'required_if:rate,null|numeric',
        ]);

        DB::beginTransaction();
        try {
            // Single VAT update
            if ($request->rate && !$request->vat_ids) {

                $vat->update($request->only(['name', 'rate', 'status']));

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
            }

            // Group VAT update
            elseif (!$request->rate && $request->vat_ids) {

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
                DB::rollBack();
                return response()->json([
                    'message' => 'Invalid data format.',
                ], 406);
            }

            DB::commit();

            return response()->json([
                'message' => 'Vat updated successfully',
                'redirect' => route('business.vats.index'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Somethings went wrong!')], 404);
        }
    }

    public function destroy(Vat $vat)
    {
        // When sub_vat is null
        if (is_null($vat->sub_vat)) {
            // Check if this VAT exists in any other VAT's sub_vat
            $vatGroupExist = Vat::where('sub_vat', 'LIKE', '%"id":' . $vat->id . '%')->exists();

            if ($vatGroupExist) {
                return response()->json([
                    'message' => 'Cannot delete. This VAT is part of a VAT group.',
                ], 404);
            }
        }

        $vat->delete();

        return response()->json([
            'message' => 'VAT Deleted Successfully',
            'redirect' => route('business.vats.index'),
        ]);
    }


    public function status(Request $request, $id)
    {
        $status = Vat::findOrFail($id);
        $status->update(['status' => $request->status]);
        return response()->json(['message' => 'Vat']);
    }

    public function deleteAll(Request $request)
    {
        $vats = Vat::whereIn('id', $request->ids)->get();

        // Filter out VATs that are part of a VAT group when sub_vat is null
        $restrictedVats = $vats->filter(function ($vat) {
            return is_null($vat->sub_vat) &&
                Vat::where('sub_vat', 'LIKE', '%"id":' . $vat->id . '%')->exists();
        });

        // If there are restricted VATs
        if ($restrictedVats->isNotEmpty()) {
            return response()->json([
                'message' => 'Some VATs cannot be deleted as they are part of a VAT group.',
            ], 404);
        }

        Vat::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => __('Selected items deleted successfully.'),
            'redirect' => route('business.vats.index'),
        ]);
    }

}
