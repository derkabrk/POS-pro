<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AcnooCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::where('business_id', auth()->user()->business_id)->latest()->get();

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
        $business_id = auth()->user()->business_id;
        $request->validate([
            'categoryName' => 'required|unique:categories,categoryName,NULL,id,business_id,' . $business_id,
        ]);

        $data = Category::create([
                    'categoryName' => $request->categoryName,
                    'variationCapacity' => $request->variationCapacity == 'true' ? 1 : 0,
                    'variationColor' => $request->variationColor == 'true' ? 1 : 0,
                    'variationSize' => $request->variationSize == 'true' ? 1 : 0,
                    'variationType' => $request->variationType == 'true' ? 1 : 0,
                    'variationWeight' => $request->variationWeight == 'true' ? 1 : 0,
                    'business_id' => $business_id
                ]);

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'categoryName' => [
                'required',
                'unique:categories,categoryName,' . $category->id . ',id,business_id,' . auth()->user()->business_id,
            ],
        ]);

        $category = $category->update([
                        'categoryName' => $request->categoryName,
                        'variationCapacity' => $request->variationCapacity == 'true' ? 1 : 0,
                        'variationColor' => $request->variationColor == 'true' ? 1 : 0,
                        'variationSize' => $request->variationSize == 'true' ? 1 : 0,
                        'variationType' => $request->variationType == 'true' ? 1 : 0,
                        'variationWeight' => $request->variationWeight == 'true' ? 1 : 0,
                    ]);

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $category,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'message' => __('Data deleted successfully.'),
        ]);
    }
}
