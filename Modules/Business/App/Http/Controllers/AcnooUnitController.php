<?php

namespace Modules\Business\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class AcnooUnitController extends Controller
{
    public function index()
    {
        $units = Unit::where('business_id', auth()->user()->business_id)->latest()->paginate(20);
        return view('business::units.index', compact('units'));
    }

    public function acnooFilter(Request $request)
    {
        $units = Unit::where('business_id', auth()->user()->business_id)->when(request('search'), function ($q) {
            $q->where(function ($q) {
                $q->where('unitName', 'like', '%' . request('search') . '%');
            });
        })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::units.datas', compact('units'))->render()
            ]);
        }

        return redirect(url()->previous());
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|boolean',
            'unitName' => 'required|string|max:255',
        ]);

        Unit::create($request->except('status', 'business_id') + [
            'business_id' => auth()->user()->business_id,
            'status' => $request->status,
        ]);

        return response()->json([
            'message'   => __('Unit saved successfully'),
            'redirect'  => route('business.units.index')
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|boolean',
            'unitName' => 'required|string|max:255,' . $id,
        ]);

        $units = Unit::find($id);

        $units->update($request->except('status', 'business_id') + [
            'business_id' => auth()->user()->business_id,
            'status' => $request->status,
        ]);

        return response()->json([
            'message'   => __('Unit updated successfully'),
            'redirect'  => route('business.units.index')
        ]);
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();
        return response()->json([
            'message'   => __('Units deleted successfully'),
            'redirect'  => route('business.units.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        Unit::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message'   => __('Unit deleted successfully'),
            'redirect'  => route('business.units.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->update(['status' => $request->status]);
        return response()->json(['message' => __('Unit')]);
    }
}
