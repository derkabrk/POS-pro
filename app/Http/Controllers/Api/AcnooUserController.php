<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AcnooUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::where('business_id', auth()->user()->business_id)->where('role', 'staff')->latest()->get();

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
        $request->validate([
            'name' => 'required|max:30',
            'password' => 'required|min:4|max:15',
            'email' => 'required|email|unique:users,email',
        ]);

        $data = User::create([
                    'role' => 'staff',
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'business_id' => auth()->user()->business_id,
                    'visibility' => [
                        'dashboardPermission' => $request->dashboardPermission == 'true' ? true : false,
                        'addExpensePermission' => $request->addExpensePermission == 'true' ? true : false,
                        'dueListPermission' => $request->dueListPermission == 'true' ? true : false,
                        'lossProfitPermission' => $request->lossProfitPermission == 'true' ? true : false,
                        'partiesPermission' => $request->partiesPermission == 'true' ? true : false,
                        'productPermission' => $request->productPermission == 'true' ? true : false,
                        'profileEditPermission' => $request->profileEditPermission == 'true' ? true : false,
                        'purchaseListPermission' => $request->purchaseListPermission == 'true' ? true : false,
                        'purchasePermission' => $request->purchasePermission == 'true' ? true : false,
                        'reportsPermission' => $request->reportsPermission == 'true' ? true : false,
                        'salePermission' => $request->salePermission == 'true' ? true : false,
                        'salesListPermission' => $request->salesListPermission == 'true' ? true : false,
                        'stockPermission' => $request->stockPermission == 'true' ? true : false,
                        'addIncomePermission' => $request->addIncomePermission == 'true' ? true : false,
                    ]
                ]);

        return response()->json([
            'message' => __('Data saved successfully.'),
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:30',
            'password' => 'nullable|min:4|max:15',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'business_id' => auth()->user()->business_id,
            'visibility' => [
                'dashboardPermission' => $request->dashboardPermission == 'true' ? true : false,
                'addExpensePermission' => $request->addExpensePermission == 'true' ? true : false,
                'dueListPermission' => $request->dueListPermission == 'true' ? true : false,
                'lossProfitPermission' => $request->lossProfitPermission == 'true' ? true : false,
                'partiesPermission' => $request->partiesPermission == 'true' ? true : false,
                'productPermission' => $request->productPermission == 'true' ? true : false,
                'profileEditPermission' => $request->profileEditPermission == 'true' ? true : false,
                'purchaseListPermission' => $request->purchaseListPermission == 'true' ? true : false,
                'purchasePermission' => $request->purchasePermission == 'true' ? true : false,
                'reportsPermission' => $request->reportsPermission == 'true' ? true : false,
                'salePermission' => $request->salePermission == 'true' ? true : false,
                'salesListPermission' => $request->salesListPermission == 'true' ? true : false,
                'stockPermission' => $request->stockPermission == 'true' ? true : false,
                'addIncomePermission' => $request->addIncomePermission == 'true' ? true : false,
            ]
        ]);

        return response()->json([
            'message' => __('Data saved successfully.')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => __('Data deleted successfully.'),
        ]);
    }
}
