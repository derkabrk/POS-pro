<?php
namespace App\Http\Controllers\Admin;

use App\Models\TicketSystem;
use App\Models\TicketCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketSystemController extends Controller
{
    /**
     * Display a listing of the tickets.
     */
    public function index()
    {
        return view('admin::ticketSystem.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        $categories = TicketCategories::all(); // Fetch all categories
        return view('admin.ticketSystem.create', compact('categories'));
    }

    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:Open,Closed,Pending',
            'priority' => 'required|string|in:Low,Medium,High',
            'category_id' => 'nullable|exists:ticket_categories,id', // Validate category_id
        ]);

        TicketSystem::create($request->all());

        return redirect()->route('admin.ticketSystem.index')->with('success', 'Ticket created successfully.');
    }

    /**
     * Show the form for editing the specified ticket.
     */
    public function edit(TicketSystem $ticketSystem)
    {
        $categories = TicketCategories::all(); // Fetch all categories
        return view('admin.ticketSystem.edit', compact('ticketSystem', 'categories'));
    }

    /**
     * Update the specified ticket in storage.
     */
    public function update(Request $request, TicketSystem $ticketSystem)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:Open,Closed,Pending',
            'priority' => 'required|string|in:Low,Medium,High',
            'category_id' => 'nullable|exists:ticket_categories,id', // Validate category_id
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