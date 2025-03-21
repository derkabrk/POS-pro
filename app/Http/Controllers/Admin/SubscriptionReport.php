<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportSubscription;
use Illuminate\Http\Request;
use App\Models\PlanSubscribe;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SubscriptionReport extends Controller
{
    public function index(Request $request)
    {
        $subscribers = PlanSubscribe::with(['plan:id,subscriptionName','business:id,companyName,business_category_id,pictureUrl','business.category:id,name','gateway:id,name'])->latest()->paginate(20);
        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function acnooFilter(Request $request)
    {
        $search = $request->input('search');

        $subscribers = PlanSubscribe::with([
            'plan:id,subscriptionName',
            'business:id,companyName,business_category_id',
            'business.category:id,name'
        ])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('duration', 'like', '%' . $search . '%')
                        ->orWhereHas('plan', function ($q) use ($search) {
                            $q->where('subscriptionName', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('gateway', function ($q) use ($search) {
                            $q->where('name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('business', function ($q) use ($search) {
                            $q->where('companyName', 'like', '%' . $search . '%')
                                ->orWhereHas('category', function ($q) use ($search) {
                                    $q->where('name', 'like', '%' . $search . '%');
                                });
                        });
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 20);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('admin.subscribers.datas', compact('subscribers'))->render()
            ]);
        }

        return redirect(url()->previous());
    }


    public function reject(Request $request, string $id)
    {

        $request->validate([
            'notes' => 'required|string|max:255',
        ]);

        $reject = PlanSubscribe::findOrFail($id);

        if ($reject) {
            $reject->update([
                'payment_status' => 'reject',
                'notes' => $request->notes,
            ]);

            return response()->json([
                'message' => 'Status Unpaid',
                'redirect' => route('admin.subscription-reports.index'),
            ]);
        } else {
            return response()->json(['message' => 'request not found'], 404);
        }
    }

    public function paid(Request $request, string $id)
    {
        $request->validate([
            'notes' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $subscribe = PlanSubscribe::findOrFail($id);

            $existingNotes = $subscribe->notes ?? [];
            $updatedNotes = array_merge($existingNotes, ['reason' => $request->notes]);

            $subscribe->update($request->except('notes') + [
                    'payment_status' => 'paid',
                    'notes' => $updatedNotes,
                ]);

            $subscribe->business->update([
                'subscriptionDate' => now(),
                'plan_subscribe_id' => $subscribe->id,
                'will_expire' => now()->addDays($subscribe->plan->duration),
            ]);

            DB::commit();
            Cache::forget('plan-data-', $subscribe->business_id);

            return response()->json([
                'message' => 'Status Paid',
                'redirect' => route('admin.subscription-reports.index'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'request not found'], 500);
        }
    }


    public function getInvoice($invoice_id)
    {
        $subscriber = PlanSubscribe::with(['plan:id,subscriptionName','business:id,companyName,business_category_id,phoneNumber,address','business.category:id,name','gateway:id,name'])->findOrFail($invoice_id);
        return view('admin.subscribers.invoice', compact('subscriber'));
    }

}
