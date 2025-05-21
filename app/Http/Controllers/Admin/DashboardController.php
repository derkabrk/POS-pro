<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Models\User;
use App\Models\Business;
use App\Models\PlanSubscribe;
use App\Models\BusinessCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dashboard-read')->only('index');
    }

    public function index()
    {
        $planData = Plan::withCount('planSubscribes')->get();

        $plans = $planData->pluck('subscriptionName')->toArray();
        $planValues = $planData->pluck('plan_subscribes_count')->toArray();

        $businesses = Business::with('enrolled_plan:id,plan_id', 'enrolled_plan.plan:id,subscriptionName', 'category:id,name')->latest()->take(5)->get();

        // Finance Overview Data (current year)
        $year = date('Y');
        $subscriptions = PlanSubscribe::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, SUM(price) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare months and values arrays
        $allMonths = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];
        $financeMonths = array_values($allMonths);
        $financeValues = array_fill(0, 12, 0);

        foreach ($subscriptions as $sub) {
            $idx = (int)$sub->month - 1;
            $financeValues[$idx] = (float)$sub->total;
        }

        return view('index', [
            'businesses' => $businesses,
            'plans' => $plans,
            'planValues' => $planValues,
            'financeMonths' => $financeMonths,
            'financeValues' => $financeValues,
        ]);
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
        $year = request('year') ?? date('Y');
        $allMonths = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];
        $subscriptions = array_fill(0, 12, 0);
        $totalSubscriptions = 0;
        $subs = PlanSubscribe::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, SUM(price) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        foreach ($subs as $sub) {
            $idx = (int)$sub->month - 1;
            $subscriptions[$idx] = (float)$sub->total;
            $totalSubscriptions += (float)$sub->total;
        }
        return response()->json([
            'subscriptions' => $subscriptions,
            'totalSubscriptions' => $totalSubscriptions,
        ]);
    }

    public function plansOverview(Request $request)
    {
        $year = $request->input('year', date('Y'));

        $subscription = PlanSubscribe::with('plan:id,subscriptionName')
            ->select('plan_id', DB::raw('COUNT(*) as plan_count'))
            ->whereYear('created_at', $year)
            ->groupBy('plan_id')
            ->orderByDesc('plan_count')
            ->get();

        $plans = [];
        $planCounts = [];
        foreach ($subscription as $item) {
            $plans[] = $item->plan->subscriptionName ?? 'Unknown';
            $planCounts[] = $item->plan_count;
        }

        return response()->json([
            'plans' => $plans,
            'planCounts' => $planCounts,
        ]);
    }
}
