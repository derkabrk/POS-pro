<?php

namespace Modules\Business\App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Party;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\SaleReturn;
use App\Models\PurchaseReturn;
use App\Models\SaleReturnDetails;
use App\Http\Controllers\Controller;
use App\Models\PurchaseReturnDetail;

class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->user()) {
            return redirect()->back()->with('error', 'You have no permission to access.');
        }

        $stocks = Product::where('business_id', auth()->user()->business_id)
                        ->whereColumn('productStock', '<=', 'alert_qty')
                        ->latest()
                        ->take(5)
                        ->get();

        $sales = Sale::with('party:id,name', 'details')
                                        ->where('business_id', auth()->user()->business_id)
                                        ->limit(5)
                                        ->get();

        $purchases = Purchase::with('details', 'party:id,name')
                                ->where('business_id', auth()->user()->business_id)
                                ->limit(5)
                                ->get();

        return view('business::dashboard.index', compact('stocks', 'purchases', 'sales'));
    }

    // Build dashboard data for both AJAX and server-side
    protected function buildDashboardData()
    {
        $businessId = auth()->user()->business_id;
        $data = [];
        $data['total_sales'] = Sale::where('business_id', $businessId)->sum('totalAmount');
        $data['this_month_total_sales'] = Sale::where('business_id', $businessId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('totalAmount');
        $data['total_purchase'] = Purchase::where('business_id', $businessId)->sum('totalAmount');
        $data['this_month_total_purchase'] = Purchase::where('business_id', $businessId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('totalAmount');
        $sale_loss_profit = Sale::where('business_id', $businessId)->sum('lossProfit');
        $this_month_loss_profit = Sale::where('business_id', $businessId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('lossProfit');
        $total_income = Income::where('business_id', $businessId)->sum('amount');
        $this_month_total_income = Income::where('business_id', $businessId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');
        $total_expense = Expense::where('business_id', $businessId)->sum('amount');
        $this_month_total_expense = Expense::where('business_id', $businessId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');
        $total_income += $sale_loss_profit > 0 ? $sale_loss_profit : 0;
        $total_expense += $sale_loss_profit < 0 ? abs($sale_loss_profit) : 0;
        $this_month_total_income += $this_month_loss_profit > 0 ? $this_month_loss_profit : 0;
        $this_month_total_expense += $this_month_loss_profit < 0 ? abs($this_month_loss_profit) : 0;
        $data['total_income'] = $total_income;
        $data['this_month_total_income'] = $this_month_total_income;
        $data['total_expense'] = $total_expense;
        $data['this_month_total_expense'] = $this_month_total_expense;
        return $data;
    }

    public function getDashboardData()
    {
        $data = $this->buildDashboardData();
        // If this is an AJAX request, return JSON
        if (request()->expectsJson() || request()->ajax()) {
            // Format currency for AJAX response
            $currency = business_currency();
            $data['total_sales'] = currency_format($data['total_sales'], 'icon', 2, $currency, true);
            $data['this_month_total_sales'] = currency_format($data['this_month_total_sales'], 'icon', 2, $currency, true);
            $data['total_purchase'] = currency_format($data['total_purchase'], 'icon', 2, $currency, true);
            $data['this_month_total_purchase'] = currency_format($data['this_month_total_purchase'], 'icon', 2, $currency, true);
            $data['total_income'] = currency_format($data['total_income'], 'icon', 2, $currency, true);
            $data['this_month_total_income'] = currency_format($data['this_month_total_income'], 'icon', 2, $currency, true);
            $data['total_expense'] = currency_format($data['total_expense'], 'icon', 2, $currency, true);
            $data['this_month_total_expense'] = currency_format($data['this_month_total_expense'], 'icon', 2, $currency, true);
            return response()->json($data);
        }
        // Otherwise, return array for server-side
        return $data;
    }

    public function overall_report() {
        $businessId = auth()->user()->business_id;

        // Calculate overall values
        $overall_purchase = Purchase::where('business_id', $businessId)
            ->whereYear('created_at', request('year') ?? date('Y'))
            ->sum('totalAmount');

        $overall_sale = Sale::where('business_id', $businessId)
            ->whereYear('created_at', request('year') ?? date('Y'))
            ->sum('totalAmount');

        $overall_income = Income::where('business_id', $businessId)
            ->whereYear('created_at', request('year') ?? date('Y'))
            ->sum('amount');

        $overall_expense = Expense::where('business_id', $businessId)
            ->whereYear('created_at', request('year') ?? date('Y'))
            ->sum('amount');

        // Get the total loss/profit for the month
        $sale_loss_profit = Sale::where('business_id', $businessId)
            ->whereYear('created_at', request('year') ?? date('Y'))
            ->sum('lossProfit');

        // Update income and expense based on lossProfit value
        $overall_income += $sale_loss_profit > 0 ? $sale_loss_profit : 0;
        $overall_expense += $sale_loss_profit < 0 ? abs($sale_loss_profit) : 0;

        $data = [
            'overall_purchase' => $overall_purchase,
            'overall_sale' => $overall_sale,
            'overall_income' => $overall_income,
            'overall_expense' => $overall_expense,
        ];

        return response()->json($data);
    }


    public function revenue(){
        $data['loss'] = Sale::where('business_id', auth()->user()->business_id)
                                ->whereYear('created_at', request('year') ?? date('Y'))
                                ->where('lossProfit', '<', 0)
                                ->selectRaw('MONTHNAME(created_at) as month, SUM(ABS(lossProfit)) as total')
                                ->orderBy('created_at')
                                ->groupBy('created_at')
                                ->get();

        $data['profit'] = Sale::where('business_id', auth()->user()->business_id)
                                ->whereYear('created_at', request('year') ?? date('Y'))
                                ->where('lossProfit', '>=', 0)
                                ->selectRaw('MONTHNAME(created_at) as month, SUM(ABS(lossProfit)) as total')
                                ->orderBy('created_at')
                                ->groupBy('created_at')
                                ->get();

        return response()->json($data);

    }

    // Returns monthly subscriptions for the Finance Overview chart
    public function subscriptionsStatistics() {
        $businessId = auth()->user()->business_id;
        $year = request('year') ?? date('Y');
        $subscriptions = array_fill(0, 12, 0);
        $totalSubscriptions = 0;

        $sales = \App\Models\Sale::where('business_id', $businessId)
            ->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();

        foreach ($sales as $sale) {
            $monthIndex = (int)$sale->month - 1;
            $subscriptions[$monthIndex] = (int)$sale->count;
            $totalSubscriptions += (int)$sale->count;
        }

        return response()->json([
            'subscriptions' => $subscriptions,
            'totalSubscriptions' => $totalSubscriptions,
        ]);
    }
}
