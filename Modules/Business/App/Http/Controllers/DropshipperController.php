<?php

namespace Modules\Business\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Business\App\Models\Dropshipper;

class DropshipperController extends Controller
{
    public function index()
    {
        $dropshippers = Dropshipper::all();
        return view('business.dropshippers.index', compact('dropshippers'));
    }

    public function create()
    {
        return view('business.dropshippers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:dropshippers,email',
            'phone' => 'nullable',
        ]);
        Dropshipper::create($request->only('name', 'email', 'phone'));
        return redirect()->route('business.dropshippers.index')->with('success', 'Dropshipper created successfully.');
    }

    public function edit(Dropshipper $dropshipper)
    {
        return view('business.dropshippers.edit', compact('dropshipper'));
    }

    public function update(Request $request, Dropshipper $dropshipper)
    {
        $request->validate([
            'store' => 'required',
            'phone' => 'nullable',
            'full_name' => 'required',
            'total_orders' => 'nullable|integer',
            'delivered' => 'nullable|integer',
            'returned' => 'nullable|integer',
            'pending' => 'nullable|integer',
            'available' => 'nullable|numeric',
            'paid' => 'nullable|numeric',
            'cashout' => 'nullable|numeric',
            'expires' => 'nullable|date',
        ]);
        $dropshipper->update($request->only([
            'store', 'phone', 'full_name', 'total_orders', 'delivered', 'returned', 'pending', 'available', 'paid', 'cashout', 'expires'
        ]));
        return redirect()->route('business.dropshippers.index')->with('success', 'Dropshipper updated successfully.');
    }

    public function destroy(Dropshipper $dropshipper)
    {
        $dropshipper->delete();
        return redirect()->route('business.dropshippers.index')->with('success', 'Dropshipper deleted successfully.');
    }

    public function transactions()
    {
        // Placeholder: implement logic to fetch transactions
        return view('business.dropshippers.transactions');
    }

    public function withdrawals()
    {
        // Placeholder: implement logic to fetch withdrawals
        return view('business.dropshippers.withdrawals');
    }
}
