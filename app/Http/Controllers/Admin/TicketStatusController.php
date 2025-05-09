<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketStatus;
use Illuminate\Http\Request;

class TicketStatusController extends Controller
{
    /**
     * Display a listing of the ticket statuses.
     */
    public function index()
    {
        $statuses = TicketStatus::all();
        return view('admin.ticketStatus.index', compact('statuses'));
    }

    /**
     * Store a newly created ticket status.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ticket_statuses',
            'color' => 'nullable|string|max:7',
        ]);

        TicketStatus::create($request->only('name', 'color'));

        return redirect()->back()->with('success', 'Status added successfully!');
    }

    /**
     * Remove the specified ticket status.
     */
    public function destroy(TicketStatus $ticketStatus)
    {
        $ticketStatus->delete();
        return redirect()->back()->with('success', 'Status deleted successfully!');
    }
}