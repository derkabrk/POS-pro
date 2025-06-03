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
        foreach ($dropshippers as $dropshipper) {
            // Example calculation logic, replace with actual relationships/queries as needed
            $dropshipper->total_orders = $dropshipper->orders()->count() ?? 0;
            $dropshipper->delivered = $dropshipper->orders()->where('status', 'delivered')->count() ?? 0;
            $dropshipper->returned = $dropshipper->orders()->where('status', 'returned')->count() ?? 0;
            $dropshipper->pending = $dropshipper->orders()->where('status', 'pending')->count() ?? 0;
            $dropshipper->available = $dropshipper->wallet_available ?? 0;
            $dropshipper->paid = $dropshipper->wallet_paid ?? 0;
            $dropshipper->cashout = $dropshipper->wallet_cashout ?? 0;
        }
        return view('business::dropshippers.index', compact('dropshippers'));
    }

    public function create()
    {
        return view('business::dropshippers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email|unique:dropshippers,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable',
            // 'store' => 'required', // Make store optional
        ]);
        $data = $request->only('full_name', 'email', 'phone');
        if ($request->filled('store')) {
            $data['store'] = $request->store;
        }
        $data['password'] = bcrypt($request->password);
        Dropshipper::create($data);
        return redirect()->route('business.dropshippers.index')->with('success', 'Dropshipper created successfully.');
    }

    public function edit(Dropshipper $dropshipper)
    {
        return view('business::dropshippers.edit', compact('dropshipper'));
    }

    public function update(Request $request, Dropshipper $dropshipper)
    {
        $request->validate([
            'store' => 'required',
            'phone' => 'nullable',
            'full_name' => 'required',
            'expires' => 'nullable|date',
        ]);
        $dropshipper->update($request->only([
            'store', 'phone', 'full_name', 'expires'
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
        return view('business::dropshippers.transactions');
    }

    public function withdrawals()
    {
        // Placeholder: implement logic to fetch withdrawals
        return view('business::dropshippers.withdrawals');
    }

    public function showRegistrationForm()
    {
        return view('business::dropshippers.registration');
    }

    public function completeRegistration(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'store' => 'required',
            'phone' => 'required',
            'wilaya' => 'required',
            'expires' => 'nullable|date',
            'store_logo' => 'nullable|image|max:2048',
        ]);
        $dropshipper = auth()->user()->dropshipper;
        $data = $request->only(['full_name', 'store', 'phone', 'wilaya', 'expires']);
        if ($request->hasFile('store_logo')) {
            $data['store_logo'] = $request->file('store_logo')->store('dropshipper_logos', 'public');
        }
        $dropshipper->update($data);
        $dropshipper->is_registered = true;
        $dropshipper->save();
        return redirect()->route('business.dropshipper.dashboard')->with('success', 'Registration completed!');
    }
}
