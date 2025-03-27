<?php

namespace Modules\Business\App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class UserRoleController extends Controller
{

    public function index()
    {
        $users = User::where('business_id', auth()->user()->business_id)->where('role', 'staff')->latest()->get();

        return view('business::roles.index', compact('users'));
    }

    public function create()
    {
        return view('business::roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:30',
            'password' => 'required|min:4|max:15',
            'email' => 'required|email|unique:users,email',
        ]);

         User::create([
            'role' => 'staff',
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'business_id' => auth()->user()->business_id,
            'visibility' => [
                'addExpensePermission' => $request->addExpensePermission == 'on' ? true : false,
                'dueListPermission' => $request->dueListPermission == 'on' ? true : false,
                'lossProfitPermission' => $request->lossProfitPermission == 'on' ? true : false,
                'partiesPermission' => $request->partiesPermission == 'on' ? true : false,
                'productPermission' => $request->productPermission == 'on' ? true : false,
                'profileEditPermission' => $request->profileEditPermission == 'on' ? true : false,
                'purchaseListPermission' => $request->purchaseListPermission == 'on' ? true : false,
                'purchasePermission' => $request->purchasePermission == 'on' ? true : false,
                'reportsPermission' => $request->reportsPermission == 'on' ? true : false,
                'salePermission' => $request->salePermission == 'on' ? true : false,
                'salesListPermission' => $request->salesListPermission == 'on' ? true : false,
                'stockPermission' => $request->stockPermission == 'on' ? true : false,
                'addIncomePermission' => $request->addIncomePermission == 'on' ? true : false,
                'shippingPermission' => $request->shippingPermission == 'on' ? true : false,
            ]
        ]);

        return response()->json([
            'message' => __('User role created successfully'),
            'redirect' => route('business.roles.index')
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (is_string($user->visibility)) {
            $user->visibility = json_decode($user->visibility, true);
        }
        return view('business::roles.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:30',
            'password' => 'nullable|min:4|max:15',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'business_id' => auth()->user()->business_id,
            'visibility' => [
                'addExpensePermission' => $request->addExpensePermission == 'on' ? true : false,
                'dueListPermission' => $request->dueListPermission == 'on' ? true : false,
                'lossProfitPermission' => $request->lossProfitPermission == 'on' ? true : false,
                'partiesPermission' => $request->partiesPermission == 'on' ? true : false,
                'productPermission' => $request->productPermission == 'on' ? true : false,
                'profileEditPermission' => $request->profileEditPermission == 'on' ? true : false,
                'purchaseListPermission' => $request->purchaseListPermission == 'on' ? true : false,
                'purchasePermission' => $request->purchasePermission == 'on' ? true : false,
                'reportsPermission' => $request->reportsPermission == 'on' ? true : false,
                'salePermission' => $request->salePermission == 'on' ? true : false,
                'salesListPermission' => $request->salesListPermission == 'on' ? true : false,
                'stockPermission' => $request->stockPermission == 'on' ? true : false,
                'addIncomePermission' => $request->addIncomePermission == 'on' ? true : false,
                'shippingPermission' => $request->shippingPermission == 'on' ? true : false,
            ]
        ]);

        return response()->json([
            'message' => __('User role updated successfully'),
            'redirect' => route('business.roles.index')
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => __('User role deleted successfully'),
            'redirect' => route('business.roles.index')
        ]);
    }
}
