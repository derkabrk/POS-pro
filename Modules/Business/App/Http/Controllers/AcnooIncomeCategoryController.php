<?php

namespace Modules\Business\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;

class AcnooIncomeCategoryController extends Controller
{
    public function index()
    {
        $income_categories = IncomeCategory::where('business_id', auth()->user()->business_id)->latest()->paginate(20);
        return view('business::income-categories.index', compact('income_categories'));
    }

    public function acnooFilter(Request $request)
    {
        $income_categories = IncomeCategory::where('business_id', auth()->user()->business_id)
        ->when(request('search'), function($q) use($request) {
                $q->where(function($q) use($request) {
                    $q->where('categoryName', 'like', '%'.$request->search.'%')
                      ->orWhere('categoryDescription', 'like', '%'.$request->search.'%');
                });
            })
            ->latest()
            ->paginate($request->per_page ?? 10);

        if($request->ajax()){
            return response()->json([
                'data' => view('business::income-categories.datas',compact('income_categories'))->render()
            ]);
        }
        return redirect(url()->previous());
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoryName' => 'required|unique:income_categories,categoryName,NULL,id,business_id,' . auth()->user()->business_id,
        ]);

        IncomeCategory::create($request->except('business_id') + [
            'business_id' => auth()->user()->business_id,
        ]);

        return response()->json([
            'message' => __('Income Category saved successfully.'),
            'redirect' => route('business.income-categories.index')
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = IncomeCategory::findOrFail($id);

        $request->validate([
            'categoryName' => [
                'required',
                'unique:income_categories,categoryName,' . $category->id . ',id,business_id,' . auth()->user()->business_id,
            ],
        ]);

        $category->update($request->except('business_id') + [
            'business_id' => auth()->user()->business_id,
        ]);

        return response()->json([
            'message' => __('Income Category updated successfully.'),
            'redirect' => route('business.income-categories.index')
        ]);
    }

    public function destroy($id)
    {
        $income_category = IncomeCategory::findOrFail($id);
        $income_category->delete();

        return response()->json([
            'message' => __('Income Category deleted successfully'),
            'redirect' => route('business.income-categories.index')
        ]);
    }

    public function status(Request $request, $id)
    {
        $income_category = IncomeCategory::findOrFail($id);
        $income_category->update(['status' => $request->status]);
        return response()->json(['message' => __('Income Category')]);
    }

    public function deleteAll(Request $request)
    {
        IncomeCategory::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('Selected item deleted successfully.'),
            'redirect' => route('business.income-categories.index'),
        ]);
    }
}
