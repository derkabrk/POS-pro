<?php
namespace App\Http\Controllers\Admin;

use App\Models\TicketCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketCategoriesController extends Controller
{
    /**
     * Display a listing of ticket categories.
     */
    public function index()
    {
        $categories = TicketCategories::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created ticket category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ticket_categories',
            'color' => 'nullable|string|max:7', // Validate color as a hex code
        ]);

        $category = TicketCategories::create([
            'name' => $request->name,
            'color' => $request->color,
        ]);

        return response()->json(['message' => 'Ticket category added successfully!', 'category' => $category]);
    }
}