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

        return view('business::ticketSystem.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        $categories = TicketCategories::all();
        $statuses = TicketStatus::all();

        return view('business.ticketSystem.create', compact('categories', 'statuses'));
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
        ]);

        TicketSystem::create([
            'title' => $request->title,
            'description' => $request->description,
            'email' => $request->email,
            'status_id' => $request->status_id,
            'priority' => $request->priority,
            'category_id' => $request->category_id,
            'business_id' => auth()->user()->business_id, // Automatically associate with the logged-in business
        ]);

        return redirect()->route('business.ticketSystem.index')->with('success', 'Ticket created successfully.');
    }
}