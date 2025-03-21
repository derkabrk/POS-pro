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

    public function getDashboardData()
    {
        $businessId = auth()->user()->business_id;

        $data['total_sales'] = currency_format(Sale::where('business_id', $businessId)->sum('totalAmount'), 'icon', 2, business_currency(), true);
        $data['this_month_total_sales'] = currency_format(Sale::where('business_id', $businessId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('totalAmount'), 'icon', 2, business_currency(), true);

        $data['total_purchase'] = currency_format(Purchase::where('business_id', $businessId)->sum('totalAmount'), 'icon', 2, business_currency(), true);
        $data['this_month_total_purchase'] = currency_format(Purchase::where('business_id', $businessId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('totalAmount'), 'icon', 2, business_currency(), true);

        // Get total and monthly lossProfit
        $sale_loss_profit = Sale::where('business_id', auth()->user()->business_id)->sum('lossProfit');
        $this_month_loss_profit = Sale::where('business_id', auth()->user()->business_id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('lossProfit');

        // Get total income and expense
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

        // Update income and expense based on lossProfit value
        $total_income += $sale_loss_profit > 0 ? $sale_loss_profit : 0;
        $total_expense += $sale_loss_profit < 0 ? abs($sale_loss_profit) : 0;

        $this_month_total_income += $this_month_loss_profit > 0 ? $this_month_loss_profit : 0;
        $this_month_total_expense += $this_month_loss_profit < 0 ? abs($this_month_loss_profit) : 0;

        // Format data for display
        $data['total_income'] = currency_format($total_income, 'icon', 2, business_currency(), true);
        $data['this_month_total_income'] = currency_format($this_month_total_income, 'icon', 2, business_currency(), true);

        $data['total_expense'] = currency_format($total_expense, 'icon', 2, business_currency(), true);
        $data['this_month_total_expense'] = currency_format($this_month_total_expense, 'icon', 2, business_currency(), true);


        $data['total_customer'] = Party::where('business_id', $businessId)->where('type', '!=', 'Supplier')->count();
        $data['this_month_total_customer'] = Party::where('business_id', $businessId)
            ->where('type', '!=', 'Supplier')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $data['total_supplier'] = Party::where('business_id', $businessId)->whereType('Supplier')->count();
        $data['this_month_total_supplier'] = Party::where('business_id', $businessId)
            ->whereType('Supplier')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();


        $sale_return_id = SaleReturn::where('business_id', $businessId)
                                    ->pluck('id');
        $data['total_sales_return'] = currency_format(SaleReturnDetails::whereIn('sale_return_id', $sale_return_id)
                                     ->sum('return_amount'), 'icon', 2, business_currency(), true);


        $saleReturns = SaleReturn::where('business_id', $businessId)
                                    ->whereYear('return_date', now()->year)
                                    ->whereMonth('return_date', now()->month)
                                    ->pluck('id');

        $data['this_month_total_sale_return'] = currency_format(SaleReturnDetails::whereIn('sale_return_id', $saleReturns)
                                                 ->sum('return_amount'), 'icon', 2, business_currency(), true);



        $purchase_return_id = PurchaseReturn::where('business_id', $businessId)
                              ->pluck('id');
        $data['total_purchase_return'] = currency_format(PurchaseReturnDetail::whereIn('purchase_return_id', $purchase_return_id)
                                        ->sum('return_amount'), 'icon', 2, business_currency(), true);


        $purchaseReturns = PurchaseReturn::where('business_id', $businessId)
                                    ->whereYear('return_date', now()->year)
                                    ->whereMonth('return_date', now()->month)
                                    ->pluck('id');

        $data['this_month_total_purchase_return'] = currency_format(PurchaseReturnDetail::whereIn('purchase_return_id', $purchaseReturns)
                                                    ->sum('return_amount'), 'icon', 2, business_currency(), true);

        return response()->json($data);
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
}
