<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Models\User;
use App\Models\Business;
use App\Models\PlanSubscribe;
use App\Models\BusinessCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dashboard-read')->only('index');
    }

    public function index()
    {
        $businesses = Business::with('enrolled_plan:id,plan_id', 'enrolled_plan.plan:id,subscriptionName', 'category:id,name')->latest()->take(5)->get();
        return view('admin.dashboard.index', compact('businesses'));
    }

    public function getDashboardData()
    {
        $data['total_businesses'] = Business::count();
        $data['expired_businesses'] = Business::where('will_expire', '<', now())->count();
        $data['plan_subscribes'] = PlanSubscribe::count();
        $data['business_categories'] = BusinessCategory::count();
        $data['total_plans'] = Plan::count();
        $data['total_staffs'] = User::whereNotIn('role', ['superadmin', 'staff', 'shop-owner'])->count();

        return response()->json($data);
    }

    public function yearlySubscriptions()
    {
        $subscriptions = PlanSubscribe::whereYear('created_at', request('year') ?? date('Y'))
                            ->selectRaw('MONTHNAME(created_at) as month, SUM(price) as total_amount')
                            ->groupBy('month')
                            ->get();

        return response()->json($subscriptions);
    }

    public function plansOverview()
    {
        $subscription = PlanSubscribe::with('plan:id,subscriptionName')->select('plan_id', DB::raw('COUNT(*) as plan_count'))
                        ->groupBy('plan_id')
                        ->orderByDesc('plan_count')
                        ->limit(4)
                        ->get();

        return response()->json($subscription);
    }
}
