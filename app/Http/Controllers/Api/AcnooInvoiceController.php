<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DueCollect;
use App\Models\Party;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleReturn;
use Illuminate\Http\Request;

class AcnooInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'party_id' => 'required|exists:parties,id'
        ]);

        $party = Party::select('id', 'due', 'name', 'type')->find(request('party_id'));

        if ($party->type == 'Supplier')
        {
            $data = $party->load('purchases_dues:id,party_id,dueAmount,paidAmount,totalAmount,invoiceNumber');
        } else {
            $data = $party->load('sales_dues:id,party_id,dueAmount,paidAmount,totalAmount,invoiceNumber');
        }

        return response()->json([
            'message' => __('Data fetched successfully.'),
            'data' => $data,
        ]);
    }

    public function newInvoice(Request $request)
    {
        $request->validate([
            'platform' => 'required|in:sales,purchases,due_collects,sales_return,purchases_return'
        ]);

        if ($request->platform == 'sales') {
            $prefix = 'S-';
            $id = Sale::where('business_id', auth()->user()->business_id)->count();
        } elseif ($request->platform == 'purchases') {
            $prefix = 'P-';
            $id = Purchase::where('business_id', auth()->user()->business_id)->count();
        } elseif ($request->platform == 'sales_return') {
            $prefix = 'SR-';
            $id = SaleReturn::where('business_id', auth()->user()->business_id)->count();
        } elseif ($request->platform == 'purchases_return') {
            // $prefix = 'PR-';
            // $id = Purchase::where('business_id', auth()->user()->business_id)->count();
        }
         else {
            $prefix = 'D-';
            $id = DueCollect::where('business_id', auth()->user()->business_id)->count();
        }

        $invoice = $prefix . str_pad($id + 1, 5, '0', STR_PAD_LEFT);

        return response()->json($invoice);
    }
}
