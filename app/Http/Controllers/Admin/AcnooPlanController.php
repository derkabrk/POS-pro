<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class AcnooPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:plans-create')->only('create', 'store');
        $this->middleware('permission:plans-read')->only('index');
        $this->middleware('permission:plans-update')->only('edit', 'update', 'status');
        $this->middleware('permission:plans-delete')->only('destroy', 'deleteAll');
    }

    public function index()
    {
        $plans = Plan::latest()->paginate(20);
        return view('admin.plans.index',  compact('plans'));
    }

    public function acnooFilter(Request $request)
    {
        $plans = Plan::when(request('search'), function ($q) {
            $q->where(function ($q) {
                $q->orWhere('subscriptionName', 'like', '%' . request('search') . '%')
                    ->orWhere('duration', 'like', '%' . request('search') . '%')
                    ->orWhere('subscriptionPrice', 'like', '%' . request('search') . '%');
            });
        })
            ->latest()
            ->paginate($request->per_page ?? 20);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('admin.plans.datas', compact('plans'))->render()
            ]);
        }

        return redirect(url()->previous());
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'duration' => 'required|string',
            'offerPrice' => 'nullable|numeric|min:0|max:9999999999999',
            'subscriptionName' => 'required|string|max:255|unique:plans,subscriptionName',
            'subscriptionPrice' => 'required|numeric|min:0|max:9999999999999',
        ]);

        Plan::create($request->except(['offerPrice','status']) + [
            'offerPrice' => $request->offerPrice ?? NULL,
            'status' => $request->status ? 1 : 0,
        ]);

        return response()->json([
            'message' => __('Subscription Plan created successfully'),
            'redirect' => route('admin.plans.index')
        ]);
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'duration' => 'required|string',
            'offerPrice' => 'nullable|numeric|min:0|max:9999999999999',
            'subscriptionPrice' => 'required|numeric|min:0|max:9999999999999',
            'subscriptionName' => 'required|string|max:255|unique:plans,subscriptionName,'.$plan->id,
        ]);

        if ($plan->subscriptionName == 'Free' && ($plan->subscriptionName != $request->subscriptionName || $plan->subscriptionPrice != $request->subscriptionPrice || $plan->offerPrice != $request->offerPrice)) {
            return response()->json([
                'message' => __('You can not change the package name & price of free plan.'),
            ], 406);
        }

        $plan->update($request->except(['offerPrice','status']) + [
            'offerPrice' => $request->offerPrice ?? NULL,
            'status' => $request->status ? 1 : 0,
        ]);

        return response()->json([
            'message' => __('Subscription Plan updated successfully'),
            'redirect' => route('admin.plans.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);
        if ($plan->subscriptionName == 'Free') {
            return response()->json([
                'message' => __('You can not change the status for free plan.'),
            ], 406);
        }
        $plan->update(['status' => $request->status]);
        return response()->json(['message' => 'Plan']);
    }

    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        if ($plan->subscriptionName == 'Free') {
            return response()->json([
                'message' => __('You can not delete free plan.'),
            ], 406);
        }

        $plan->delete();

        return response()->json([
            'message'   => __('Subscription Plan deleted successfully'),
            'redirect'  => route('admin.plans.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        Plan::whereIn('id', $request->ids)->where('subscriptionName', '!=', 'Free')->delete();
        return response()->json([
            'message' => __('Subscription plan deleted successfully'),
            'redirect' => route('admin.plans.index')
        ]);
    }
}
