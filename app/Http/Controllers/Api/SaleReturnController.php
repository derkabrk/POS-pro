<?php

namespace App\Http\Controllers\Api;

use App\Models\Sale;
use App\Models\Party;
use App\Models\SaleReturn;
use App\Models\SaleDetails;
use Illuminate\Http\Request;
use App\Models\SaleReturnDetails;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Product;

class SaleReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SaleReturn::with('sale:id,party_id,isPaid,totalAmount,dueAmount,paidAmount,invoiceNumber', 'sale.party:id,name', 'details')
                ->whereBetween('return_date', [request()->start_date, request()->end_date])
                ->where('business_id', auth()->user()->business_id)
                ->latest()
                ->get();

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
            'return_qty' => 'required',
            'return_date' => 'required',
            'return_amount' => 'required',
            'sale_detail_id' => 'required',
            'sale_id' => 'required|exists:sales,id',
        ]);

        DB::beginTransaction();
        try {

            $sale_return = SaleReturn::create($request->all() + [
                'business_id' => auth()->user()->business_id,
            ]);

            $sale = Sale::findOrFail($request->sale_id);
            $party = Party::find($sale->party_id);
            $total_return_amount = array_sum($request->return_amount);

            if ($party) {
                $party->update([
                    'due' => $party->due > $total_return_amount ? $party->due - $total_return_amount : 0,
                ]);
            }

            $sale->update([
                'dueAmount' => $request->dueAmount,
                'paidAmount' => $request->paidAmount,
                'totalAmount' => $request->totalAmount,
                'discountAmount' => $request->discountAmount,
                'lossProfit' => array_sum($request->lossProfit) - $request->discountAmount,
            ]);

            $data = [];
            foreach ($request->sale_detail_id as $key => $detail_id) {

                $sale_detail = SaleDetails::findOrFail($detail_id);
                Product::findOrFail($sale_detail->product_id)->increment('productStock', $request->return_qty[$key]);

                $sale_detail->update([
                    'lossProfit' => $request->lossProfit[$key],
                    'quantities' => $sale_detail->quantities - $request->return_qty[$key],
                ]);

                $data[] = [
                    'sale_detail_id' => $detail_id,
                    'sale_return_id' => $sale_return->id,
                    'return_qty' => $request->return_qty[$key],
                    'business_id' => auth()->user()->business_id,
                    'return_amount' => $request->return_amount[$key],
                ];
            }

            SaleReturnDetails::insert($data);

            DB::commit();

            return response()->json([
                'message' => __('Data saved successfully.'),
                'data' => $sale_return,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Transaction failed: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $data = SaleReturn::with('sale:id,party_id,isPaid,totalAmount,dueAmount,paidAmount,invoiceNumber', 'sale.party:id,name', 'details')->findOrFail($id);

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $data,
        ]);
    }
}
