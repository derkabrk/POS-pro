<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $page_data = get_option('manage-pages');
        $general = Option::where('key','general')->first();
        return view('web.contact.index',compact('page_data','general'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'company_name' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create($request->all());

        return response()->json([
            'message'   => __('Your Message Submitted successfully'),
            'redirect'  => route('contact.index')
        ]);
    }
}
