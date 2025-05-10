<?php

namespace Modules\Business\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TicketSystem;
use App\Models\TicketCategories;
use App\Models\TicketStatus;
use Illuminate\Http\Request;

class TicketSystemController extends Controller
{
    /**
     * Display a listing of the tickets for the business.
     */
    public function index()
    {
        $tickets = TicketSystem::where('business_id', auth()->user()->business_id)->paginate(10);
        $categories = TicketCategories::all(); // Fetch all categories

        return view('business::ticketSystem.index', compact('tickets', 'categories'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        $categories = TicketCategories::all();
        $statuses = TicketStatus::all();

        return view('business::ticketSystem.create', compact('categories', 'statuses'));
    }

    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'nullable|exists:ticket_categories,id', // Ensure the category exists
        ]);

        // Create the ticket and associate it with the logged-in business
        TicketSystem::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'business_id' => auth()->user()->business_id, // Associate with the logged-in business
        ]);

        // Redirect back with a success message
        return redirect()->route('business.ticketSystem.index')->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified ticket.
     */
    public function show($id)
    {
        $ticket = TicketSystem::with(['category', 'status'])->findOrFail($id);

        return view('business.ticketSystem.show', compact('ticket'));
    }
}