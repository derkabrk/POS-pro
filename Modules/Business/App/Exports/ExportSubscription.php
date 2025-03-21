<?php

namespace Modules\Business\App\Exports;

use App\Models\PlanSubscribe;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportSubscription implements FromView
{
    public function view(): View
    {
        return view('business::reports.subscription-reports.excel-csv', [
            'subscribers' => PlanSubscribe::with(['plan:id,subscriptionName','business:id,companyName,business_category_id,pictureUrl','business.category:id,name','gateway:id,name'])->where('business_id', auth()->user()->business_id)->latest()->get()
        ]);
    }
}
