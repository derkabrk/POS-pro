<?php
namespace App\Http\Controllers;

use App\Models\TicketSystem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketSystemController extends Controller
{
    /**
     * Display a listing of the tickets.
     */
    public function index()
    {
        $tickets = TicketSystem::latest()->paginate(10);
        return view('admin::ticketSystem.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        return view('admin::ticketSystem.create');
    }

    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Open,Closed,Pending',
            'priority' => 'required|in:Low,Medium,High',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        TicketSystem::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.ticketSystem.index')->with('success', 'Ticket created successfully.');
    }

    /**
     * Show the form for editing the specified ticket.
     */
    public function edit(TicketSystem $ticketSystem)
    {
        return view('admin::ticketSystem.edit', compact('ticketSystem'));
    }

    /**
     * Update the specified ticket in storage.
     */
    public function update(Request $request, TicketSystem $ticketSystem)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Open,Closed,Pending',
            'priority' => 'required|in:Low,Medium,High',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $ticketSystem->update($request->all());

        return redirect()->route('admin.ticketSystem.index')->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified ticket from storage.
     */
    public function destroy(TicketSystem $ticketSystem)
    {
        $ticketSystem->delete();

        return redirect()->route('admin.ticketSystem.index')->with('success', 'Ticket deleted successfully.');
    }
}