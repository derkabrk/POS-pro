<?php
namespace App\Http\Controllers\Admin;

use App\Models\TicketSystem;
use App\Models\TicketCategories;
use App\Models\TicketStatus;
use App\Models\TicketReply;
use App\Models\Business; // Assuming you have a Business model
use App\Models\User; // Assuming you have a User model
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketSystemController extends Controller
{
    /**
     * Display a listing of the tickets.
     */
    public function index()
    {
        $tickets = TicketSystem::with('category')->paginate(10);
        $categories = TicketCategories::all();
        $statuses = TicketStatus::all();

        return view('admin.ticketSystem.index', compact('tickets', 'categories', 'statuses'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        $categories = TicketCategories::all();
        $statuses = TicketStatus::all();
        $businesses = Business::all();
        $users = User::whereIn('role', ['Admin', 'Super Admin'])->get(); // Fetch only Admin & Super Admin users

        return view('admin.ticketSystem.create', compact('categories', 'statuses', 'businesses', 'users'));
    }

    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'email' => 'required|email',
            'status_id' => 'required|exists:ticket_statuses,id',
            'priority' => 'required|string|in:Low,Medium,High',
            'category_id' => 'nullable|exists:ticket_categories,id',
            'business_id' => 'nullable|exists:businesses,id',
            'assign_to' => 'nullable|exists:users,id', // Validate assign_to
        ]);

        // Create the ticket
        TicketSystem::create([
            'title' => $request->title,
            'description' => $request->description,
            'email' => $request->email,
            'status_id' => $request->status_id,
            'priority' => $request->priority,
            'category_id' => $request->category_id,
            'business_id' => $request->business_id,
            'assign_to' => $request->assign_to, // Save the assigned user
        ]);

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
     * Update the status of the specified ticket.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_id' => 'required|exists:ticket_statuses,id', // Ensure the status exists
        ]);

        $ticket = TicketSystem::findOrFail($id);
        $ticket->update([
            'status_id' => $request->status_id,
        ]);

        return redirect()->back()->with('success', 'Ticket status updated successfully.');
    }

    /**
     * Display the specified ticket details.
     */
    public function show($id)
    {
        $ticket = TicketSystem::with(['category', 'status', 'assignedUser', 'replies', 'user'])->findOrFail($id);
        // Find related tickets (same category, not this ticket)
        $relatedTickets = collect();
        if ($ticket->category_id) {
            $relatedTickets = TicketSystem::where('category_id', $ticket->category_id)
                ->where('id', '!=', $ticket->id)
                ->latest()
                ->take(5)
                ->get();
        }
        // Optionally, you may want to pass $users and $statuses if used in the view
        $users = \App\Models\User::all();
        $statuses = \App\Models\TicketStatus::all();
        return view('admin.ticketSystem.tickets-details', compact('ticket', 'relatedTickets', 'users', 'statuses'));
    }

    /**
     * Remove the specified ticket from storage.
     */
    public function destroy(TicketSystem $ticketSystem)
    {
        $ticketSystem->delete();

        return redirect()->route('admin.ticketSystem.index')->with('success', 'Ticket deleted successfully.');
    }

    public function reply(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:ticket_systems,id',
            'message' => 'required|string',
        ]);

        // Save the reply
        TicketReply::create([
            'ticket_id' => $request->ticket_id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->route('admin.ticketSystem.index')->with('success', 'Reply sent successfully.');
    }
}