<?php

namespace Modules\Business\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use Illuminate\Validation\Rule;

class AcnooPaymentTypeController extends Controller
{
    public function index()
    {
        $paymentTypes = PaymentType::where('business_id', auth()->user()->business_id)->latest()->paginate(20);
        return view('business::payment-types.index', compact('paymentTypes'));
    }

    public function acnooFilter(Request $request)
    {
        $paymentTypes = PaymentType::where('business_id', auth()->user()->business_id)
            ->when(request('search'), function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::payment-types.datas', compact('paymentTypes'))->render()
            ]);
        }
        return redirect(url()->previous());
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|boolean',
            'name' => [
                'required',
                Rule::unique('payment_types')->where(function ($query) {
                    return $query->where('business_id', auth()->user()->business_id);
                }),
            ],
        ]);

        PaymentType::create($request->except('business_id') + [
            'business_id' => auth()->user()->business_id,
        ]);

        return response()->json([
            'message' => __('Payemnt Type created cuccessfully'),
            'redirect' => route('business.payment-types.index'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $paymentType = PaymentType::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:payment_types,name,' . $paymentType->id . ',id,business_id,' . auth()->user()->business_id,
            'status' => 'required|boolean',
        ]);

        $paymentType->update($request->except('business_id') + [
            'business_id' => auth()->user()->business_id,
        ]);

        return response()->json([
            'message' => __('Payemnt Type updated successfully'),
            'redirect' => route('business.payment-types.index'),
        ]);
    }

    public function destroy($id)
    {
        $paymentType = PaymentType::findOrFail($id);

        $paymentType->delete();

        return response()->json([
            'message' => __('Payemnt Type deleted successfully'),
            'redirect' => route('business.payment-types.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $paymentType = PaymentType::findOrFail($id);
        $paymentType->update(['status' => $request->status]);
        return response()->json(['message' => __('Payemnt Type')]);
    }

    public function deleteAll(Request $request)
    {
        $idsToDelete = $request->input('ids');
        PaymentType::whereIn('id', $idsToDelete)->delete();
        return response()->json([
            'message' => __('Selected Payemnt Type deleted successfully'),
            'redirect' => route('business.payment-types.index')
        ]);
    }
}
