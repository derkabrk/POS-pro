<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\Expense;
use App\Models\Business;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AcnooExpenseController extends Controller
{

    public function index()
    {
        $expense_categories = ExpenseCategory::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();
        $expenses = Expense::with('category:id,categoryName', 'payment_type:id,name')->where('business_id', auth()->user()->business_id)->latest()->paginate(20);
        $payment_types = PaymentType::where('business_id', auth()->user()->business_id)->whereStatus(1)->latest()->get();

        return view('business::expenses.index', compact('expenses', 'expense_categories', 'payment_types'));
    }


    public function acnooFilter(Request $request)
    {
        $expenses = Expense::with('category:id,categoryName', 'payment_type:id,name')
            ->where('business_id', auth()->user()->business_id)
            ->when(request('search'), function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('amount', 'like', '%' . $request->search . '%')
                        ->orWhere('expanseFor', 'like', '%' . $request->search . '%')
                        ->orWhere('paymentType', 'like', '%' . $request->search . '%')
                        ->orWhere('referenceNo', 'like', '%' . $request->search . '%')
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
                'data' => view('business::expenses.datas', compact('expenses'))->render()
            ]);
        }
        return redirect(url()->previous());
    }


    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'payment_type_id' => 'required|exists:payment_types,id',
            'expenseFor' => 'nullable|string',
            'referenceNo' => 'nullable|string',
            'expenseDate' => 'nullable|string',
            'note' => 'nullable|string',
            'expense_category_id' => 'required|exists:expense_categories,id',
        ]);
        DB::beginTransaction();
        try {
            $business_id = auth()->user()->business_id;

            Business::findOrFail(auth()->user()->business_id)->decrement('remainingShopBalance', $request->amount);

            $expense = Expense::create($request->except('status') + [
                    'user_id' => auth()->id(),
                    'business_id' => auth()->user()->business_id,
                ]);

            sendNotifyToUser($expense->id, route('business.expenses.index', ['id' => $expense->id]), __('Expense has been created.'), $business_id);

            DB::commit();

            return response()->json([
                'message' => __('Expense saved successfully.'),
                'redirect' => route('business.expenses.index')
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
            'expenseFor' => 'nullable|string',
            'referenceNo' => 'nullable|string',
            'expenseDate' => 'nullable|string',
            'note' => 'nullable|string',
            'expense_category_id' => 'required|exists:expense_categories,id',
        ]);

        DB::beginTransaction();
        try {
            $business_id = auth()->user()->business_id;
            $expense = Expense::findOrFail($id);

            $business = Business::findOrFail($business_id);
            $business->decrement('remainingShopBalance', $request->amount - $expense->amount);

            $expense->update($request->except('status') + [
                    'user_id' => auth()->id(),
                    'business_id' => auth()->user()->business_id,
                ]);

            DB::commit();

            sendNotifyToUser($expense->id, route('business.expenses.index', ['id' => $expense->id]), __('Expense has been updated.'), $business_id);

            return response()->json([
                'message' => __('Expense updated successfully.'),
                'redirect' => route('business.expenses.index')
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
            $expense = Expense::findOrFail($id);
            Business::findOrFail(auth()->user()->business_id)->increment('remainingShopBalance', $expense->amount);
            sendNotifyToUser($expense->id, route('business.expenses.index', ['id' => $expense->id]), __('Expense has been deleted.'), $expense->business_id);
            $expense->delete();

            DB::commit();

            return response()->json([
                'message' => __('Expense deleted successfully'),
                'redirect' => route('business.expenses.index'),
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Somethings went wrong!')], 404);
        }

    }

    public function deleteAll(Request $request)
    {
        DB::beginTransaction();
        try {
            $expenses = Expense::whereIn('id', $request->ids)->get();
            $totalAmount = $expenses->sum('amount');
            Business::findOrFail(auth()->user()->business_id)->increment('remainingShopBalance', $totalAmount);
            Expense::whereIn('id', $request->ids)->delete();
            foreach ($expenses as $expense) {
                sendNotifyToUser($expense->id, route('business.expenses.index', ['id' => $expense->id]), __('Expense has been deleted.'), $expense->business_id);
            }

            DB::commit();

            return response()->json([
                'message' => __('Selected items deleted successfully.'),
                'redirect' => route('business.expenses.index'),
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('Something went wrong!')], 404);
        }
    }
}

