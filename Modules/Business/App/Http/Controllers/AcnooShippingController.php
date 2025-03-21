<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Business\App\Exports\ExportCurrentStock;

class AcnooShippingController extends Controller
{

    public function index()
    {
        $Shipping = Shipping::latest()->paginate(20);
        return view('business::shipping.index', compact('Shipping'));
    }
}
