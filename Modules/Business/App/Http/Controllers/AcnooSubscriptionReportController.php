<?php

namespace Modules\Business\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanSubscribe;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportSubscription;
use Modules\Business\App\Exports\ExportTransaction;

class AcnooSubscriptionReportController extends Controller
{
    public function index()
    {
        $subscribers = PlanSubscribe::with(['plan:id,subscriptionName','business:id,companyName,business_category_id,pictureUrl','business.category:id,name','gateway:id,name'])->where('business_id', auth()->user()->business_id)->latest()->paginate(20);
        return view('business::reports.subscription-reports.subscription-reports', compact('subscribers'));
    }

    public function acnooFilter(Request $request)
    {
        $search = $request->input('search');

        $subscribers = PlanSubscribe::with(['plan:id,subscriptionName','business:id,companyName,business_category_id,pictureUrl','business.category:id,name','gateway:id,name'])->where('business_id', auth()->user()->business_id)
        ->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('duration', 'like', '%' . $search . '%')
                    ->orWhereHas('plan', function ($q) use ($search) {
                        $q->where('subscriptionName', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('gateway', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        })
        ->latest()
            ->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::reports.subscription-reports.datas', compact('subscribers'))->render()
            ]);
        }
        return redirect(url()->previous());
    }

    public function generatePDF(Request $request)
    {
        $subscribers = PlanSubscribe::with(['plan:id,subscriptionName','business:id,companyName,business_category_id,pictureUrl','business.category:id,name','gateway:id,name'])->where('business_id', auth()->user()->business_id)->latest()->get();
        $pdf = Pdf::loadView('business::reports.subscription-reports.pdf', compact('subscribers'));
        return $pdf->download('subscribers.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ExportSubscription, 'subscribers.xlsx');
    }

    public function exportCsv()
    {
        return Excel::download(new ExportSubscription, 'subscribers.csv');
    }

    public function getInvoice($invoice_id)
    {
        $subscriber = PlanSubscribe::with(['plan:id,subscriptionName','business:id,companyName,business_category_id,pictureUrl,phoneNumber,address','business.category:id,name','gateway:id,name'])->where('business_id', auth()->user()->business_id)->findOrFail($invoice_id);
        return view('business::reports.subscription-reports.invoice', compact('subscriber'));
    }
}
