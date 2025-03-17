<?php

namespace App\Http\Controllers\Api;

use App\Models\Party;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\PurchaseReturn;
use App\Models\PurchaseDetails;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PurchaseReturnDetail;

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PurchaseReturn::with('purchase:id,party_id,isPaid,totalAmount,dueAmount,paidAmount,invoiceNumber', 'purchase.party:id,name', 'details')
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
            'purchase_id' => 'required|exists:purchases,id',
            'return_date' => 'required',
            'purchase_detail_id' => 'required',
            'return_amount' => 'required',
            'return_qty' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $purchase_return = PurchaseReturn::create($request->all() + [
                'business_id' => auth()->user()->business_id,
            ]);

            $purchase = Purchase::findOrFail($request->purchase_id);
            $party = Party::find($purchase->party_id);
            $total_return_amount = array_sum($request->return_amount);

            if ($party) {
                $party->update([
                    'due' => $party->due > $total_return_amount ? $party->due - $total_return_amount : 0,
                ]);
            }

            $purchase->update([
                'dueAmount' => $request->dueAmount,
                'paidAmount' => $request->paidAmount,
                'totalAmount' => $request->totalAmount,
                'discountAmount' => $request->discountAmount,
            ]);

            $data = [];
            foreach ($request->purchase_detail_id as $key => $detail_id) {

                $purchase_detail = PurchaseDetails::findOrFail($detail_id);
                Product::findOrFail($purchase_detail->product_id)->decrement('productStock', $request->return_qty[$key]);

                $purchase_detail->update([
                    'quantities' => $purchase_detail->quantities - $request->return_qty[$key],
                ]);

                $data[] = [
                    'purchase_detail_id' => $detail_id,
                    'purchase_return_id' => $purchase_return->id,
                    'return_qty' => $request->return_qty[$key],
                    'business_id' => auth()->user()->business_id,
                    'return_amount' => $request->return_amount[$key],
                ];
            }

            PurchaseReturnDetail::insert($data);

            DB::commit();

            return response()->json([
                'message' => __('Data saved successfully.'),
                'data' => $purchase_return,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Transaction failed: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $data = PurchaseReturn::with('purchase:id,party_id,isPaid,totalAmount,dueAmount,paidAmount,invoiceNumber', 'purchase.party:id,name', 'details')->findOrFail($id);

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $data,
        ]);
    }
}
