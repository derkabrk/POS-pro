<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Income;
use App\Models\Business;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AcnooIncomeController extends Controller
{
    public function index()
    {
        $income_categories = IncomeCategory::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();
        $incomes = Income::with('category:id,categoryName', 'payment_type:id,name')->where('business_id', auth()->user()->business_id)->latest()->paginate(20);
        $payment_types = PaymentType::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();

        return view('business::incomes.index', compact('incomes', 'income_categories', 'payment_types'));
    }

    public function acnooFilter(Request $request)
    {
        $incomes = Income::with('category:id,categoryName', 'payment_type:id,name')
            ->where('business_id', auth()->user()->business_id)
            ->when(request('search'), function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('amount', 'like', '%' . $request->search . '%')
                        ->orWhere('incomeFor', 'like', '%' . $request->search . '%')
                        ->orWhere('paymentType', 'like', '%' . $request->search . '%')
                        ->orWhere('referenceNo', 'like', '%' . $request->search . '%')
                        ->orWhere('incomeDate', 'like', '%' . $request->search . '%')
                        ->orWhereHas('category', function ($q) use ($request) {
                            $q->where('categoryName', 'like', '%' . $request->search . '%');
                        })
                        ->orWhereHas('payment_type', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->search . '%');
                        });
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if ($request->ajax()) {
            return response()->json([
                'data' => view('business::incomes.datas', compact('incomes'))->render()
            ]);
        }
        return redirect(url()->previous());
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'payment_type_id' => 'required|exists:payment_types,id',
            'incomeFor' => 'nullable|string',
            'referenceNo' => 'nullable|string',
            'incomeDate' => 'nullable|string',
            'note' => 'nullable|string',
            'income_category_id' => 'required|exists:income_categories,id',
        ]);

        DB::beginTransaction();
        try {
            $business_id = auth()->user()->business_id;

            Business::findOrFail(auth()->user()->business_id)->increment('remainingShopBalance', $request->amount);

            $income = Income::create($request->except('status') + [
                    'user_id' => auth()->id(),
                    'business_id' => auth()->user()->business_id,
                ]);

            DB::commit();

            sendNotifyToUser($income->id, route('business.incomes.index', ['id' => $income->id]), __('Income has been created.'), $business_id);


            return response()->json([
                'message' => __('Income saved successfully.'),
                'redirect' => route('business.incomes.index')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Somethings went wrong!')], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'payment_type_id' => 'required|exists:payment_types,id',
            'incomeFor' => 'nullable|string',
            'referenceNo' => 'nullable|string',
            'incomeDate' => 'nullable|string',
            'note' => 'nullable|string',
            'income_category_id' => 'required|exists:income_categories,id',
        ]);
        DB::beginTransaction();
        try {
            $business_id = auth()->user()->business_id;

            $income = Income::findOrFail($id);

            $business = Business::findOrFail($business_id);

            $business->increment('remainingShopBalance', $request->amount - $income->amount);

            $income->update($request->except('status') + [
                    'user_id' => auth()->id(),
                    'business_id' => auth()->user()->business_id,
                ]);

            sendNotifyToUser($income->id, route('business.incomes.index', ['id' => $income->id]), __('Income has been updated.'), $business_id);

            DB::commit();

            return response()->json([
                'message' => __('Income updated successfully.'),
                'redirect' => route('business.incomes.index')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Somethings went wrong!')], 404);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $income = Income::findOrFail($id);
            $business = Business::findOrFail(auth()->user()->business_id);

            $business->decrement('remainingShopBalance', $income->amount);

            sendNotifyToUser($income->id, route('business.incomes.index', ['id' => $income->id]), __('Income has been deleted.'), $income->business_id);

            $income->delete();

            DB::commit();

            return response()->json([
                'message' => __('Income deleted successfully'),
                'redirect' => route('business.incomes.index'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Something went wrong!')], 404);
        }
    }

    public function deleteAll(Request $request)
    {
        DB::beginTransaction();
        try {
            $incomes = Income::whereIn('id', $request->ids)->get();
            $totalAmount = $incomes->sum('amount');
            $business = Business::findOrFail(auth()->user()->business_id);

            $business->decrement('remainingShopBalance', $totalAmount);

            foreach ($incomes as $income) {
                sendNotifyToUser($income->id, route('business.incomes.index', ['id' => $income->id]), __('Income has been deleted.'), $income->business_id);
            }

            Income::whereIn('id', $request->ids)->delete();

            DB::commit();

            return response()->json([
                'message' => __('Selected Items deleted successfully.'),
                'redirect' => route('business.incomes.index'),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Something went wrong!')], 404);
        }
    }
}
